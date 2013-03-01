<?php

use CMS\Application;
use Monolog\Logger;
use Monolog\Handler\SyslogHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\ArrayCache;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use CMS\CmsSessionHandler;
use CMS\Event\PageEvent;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use Aura\Router\Map as RouterMap;
use Aura\Router\DefinitionFactory as RouterDefinitionFactory;
use Aura\Router\RouteFactory as RouterRouteFactory;

error_reporting(E_ALL);
date_default_timezone_set('UTC');

$loader = require 'vendor/autoload.php';

// Temporary
//$loader->add('', __DIR__.'/src');

$app = new Application;

/**
 * Error/Exception handling
 */
set_error_handler(function ($no, $str, $file, $line) {
    throw new \ErrorException($str, $no, 0, $file, $line);
});

set_exception_handler(function($exception) use ($app) {
    try {
        $data = [
            'page' => $app['db.page']->getError(500),
            'exception' => $exception,
        ];
        $template = $app['tpl']->render('errors/500.twig', $data);
        $app->finish($template);
    } catch (\Exception $e) {
        die(var_dump($e));
    }
});

$app['autoloader'] = $loader;

/**
 * Grab application configuration
 */
$app['app.config'] = require 'config/app.php';
$env = $app['app.config']['environment'];

$app['paths.root'] = __DIR__;

$app['event.dispatcher'] = $app->share(function() use ($app) {
    return new EventDispatcher();
});

$app['event.page'] = $app->share(function() use ($app) {
    return new PageEvent;
});

$app['router'] = $app->share(function() use ($app) {
    if ($app['cache']->contains('nerd.router')) {
        return $app['cache']->fetch('nerd.router');
    }

    $routerFunc = require __DIR__.'/routes.php';
    $router = new RouterMap(new RouterDefinitionFactory, new RouterRouteFactory);
    $routerFunc($router);
    $app['cache']->save('nerd.router', $router);

    // CACHE ME!
    return $router;
});

/**
 * Setup the logger
 */
$app['logger'] = $app->share(function() use ($app) {
    $logger = new Logger('Nerd');
    $logger->pushHandler($app['log.handler']);

    return $logger;
});

$app['log.handler'] = $app->share(function() use ($app) {
    return new SyslogHandler('Nerd', LOG_USER, Logger::ERROR);
});

/**
 * Generate request
 */
$app['request'] = $app->share(function() use ($app) {
    return Request::createFromGlobals();
});

$app['ip'] = $app['request']->getClientIp();
$app['host'] = $app['request']->getHost();
$app['uri'] = $app['request']->getPathInfo();

$app['response'] = new Response;

$app['post'] = $app->share(function() use ($app) {
    return $app['request']->request;
});

$app['get'] = $app->share(function() use ($app) {
    return $app['request']->query;
});

$app['server'] = $app->share(function() use ($app) {
    return $app['request']->server;
});

$app['session'] = $app->share(function() use ($app) {
    $saveHandler = new CmsSessionHandler($app['db']);
    $storage = new NativeSessionStorage([], $saveHandler);
    $session = new Session($storage);
    $session->start();

    return $session;
});

$app['flash'] = $app->share(function() use ($app) {
    return $app['session']->getFlashBag();
});

$app['cache'] = $app->share(function() use ($app, $env) {
    $cache = $env === Application::ENV_PRODUCTION ? new ApcCache : new ArrayCache;
    $cache->setNamespace('nerd_');

    return $cache;
});

/**
 * Setup the database
 */
$app['db'] = $app->share(function() use ($app, $env) {

    // Register Annotation directories for Doctrine
    //AnnotationRegistry::registerAutoloadNamespace('Symfony\Component\Validation\Constraints', __DIR__.'/vendor/symfony/validator');
    AnnotationRegistry::registerAutoloadNamespace('Doctrine\ORM\Mapping', __DIR__.'/vendor/doctrine/orm/lib');
    AnnotationRegistry::registerAutoloadNamespace('Gedmo\Mapping\Annotation', __DIR__.'/vendor/gedmo/doctrine-extensions/lib');

    $cache = $app['cache'];
    $config = new Configuration;
    $config->setMetadataCacheImpl($cache);
    $driverImpl = $config->newDefaultAnnotationDriver(__DIR__.'/src/CMS/Entity');
    $config->setMetadataDriverImpl($driverImpl);
    $config->setQueryCacheImpl($cache);
    $config->setResultCacheImpl($cache);
    $config->setProxyDir(__DIR__.'/storage/proxies');
    $config->setProxyNamespace('CMS\Proxies');
    $config->setAutoGenerateProxyClasses($env !== Application::ENV_PRODUCTION);
    $app['db.config'] = $config;
    $connectionOptions = require 'config/db.php';

    return EntityManager::create($connectionOptions, $config);
});

$app['db.page'] = $app->share(function() use ($app) {
    $pageRepository = $app['db']->getRepository('CMS\Entity\Page');
    $pageRepository->setSite($app['site']);

    return $pageRepository;
});

$app['db.site'] = $app->share(function() use ($app) {
    return $app['db']->getRepository('CMS\Entity\Site');
});

$app['db.user'] = $app->share(function() use ($app) {
    return $app['db']->getRepository('CMS\Entity\User');
});

$app['db.session'] = $app->share(function() use ($app) {
    return $app['db']->getRepository('CMS\Entity\Session');
});

$app['db.role'] = $app->share(function() use ($app) {
    return $app['db']->getRepository('CMS\Entity\Role');
});

$app['db.post'] = $app->share(function() use ($app) {
    $postRepository = $app['db']->getRepository('CMS\Entity\Post');
    $postRepository->setSite($app['site']);

    return $postRepository;
});

$app['db.permission'] = $app->share(function() use ($app) {
    return $app['db']->getRepository('CMS\Entity\Permission');
});

/**
 * Grab the current site
 */
$app['site'] = $app->share(function() use ($app) {
    return $app['db.site']->findOneByHost($app['host']);
});

/**
 * Setup the template engine
 */
$app['tpl'] = $app->share(function() use ($app, $env) {
    $site = $app['site'];
    $path = [
        __DIR__."/storage/themes/{$site->getTheme()}/views",
        __DIR__.'/views'
    ];

    $isDebug = $env !== Application::ENV_PRODUCTION;
    $loader = new Twig_Loader_Filesystem($path);
    $twig = new Twig_Environment($loader, array(
        'cache' => __DIR__.'/storage/templates',
        'debug' => $isDebug,
        'auto_reload' => $isDebug,
        'strict_variables' => true,
        'base_template_class' => '\\CMS\\Twig\\Template'
    ));

    // Load extensions
    if ($isDebug) {
        $twig->addExtension(new Twig_Extension_Debug());
    }
    $twig->addExtension(new Twig_Extension_Cms);
    $twig->addGlobal('debugging', $isDebug);

    return $twig;
});


return $app;