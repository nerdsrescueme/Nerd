<?php

/**
 * Front controller.
 */
$app = require '../bootstrap.php';

$app->setup();

$c = new \CMS\Entity\Comment;

die(var_dump($c));

$app->authenticateFromSession();

    try {
        $event = $app->dispatch();
        $page = $event->getPage();
        $data = $event->getData();
    } catch (\CMS\Exception $e) {
        $page = false;
    }

    if (!$page) {
        $app['response']->setStatusCode(404);
        $page = $app['db.page']->getError(404);
    }

    $data = $data + [
        'app' => $app,
        'flash' => $app['flash'],
        'page' => $page,
        'user' => isset($app['current_user']) ? $app['current_user']: false,
    ];

$app->finish(
    $app['tpl']->render($page->getLayout().'.twig', $data)
);