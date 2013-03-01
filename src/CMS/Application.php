<?php

namespace CMS;

use Symfony\Component\HttpFoundation\RedirectResponse;

class Application extends \Pimple
{
    const ENV_TESTING = 'test';
    const ENV_DEVELOPMENT = 'dev';
    const ENV_PRODUCTION = 'prod';

    public function authenticate($email, $password, $encrypt = true)
    {
        $encrypt and $password = $this->_encrypt($password);
        $this['current_user'] = $this['db.user']->authenticate($email, $password);

        if ($this['current_user']) {
            $this['session']->set('user', ['email' => $email, 'password' => $password]);
        }

        return $this['current_user'] ?: false;
    }

    public function authenticateFromSession()
    {
        if ($this['session']->has('user')) {
            $details = $this['session']->get('user');
            $user = $this->authenticate($details['email'], $details['password'], false);

            return $user ?: false;
        }
    }

    public function deauthenticate()
    {
        $this['session']->invalidate();
        $this['current_user'] = null;
    }

    public function dispatch()
    {
        $this['event.dispatcher']->dispatch($this['resolver'], $this['event.page']);

        return $this['event.page'];
    }

    public function finish($content = '')
    {
        // Make ready and send the response
        $this['response']->setContent($content);
        $this['response']->prepare($this['request']);
        $this['response']->send();

        // Persist all leftover added/updated database objects
        $this['session']->save();
        $this['db']->flush();
    }

    public function in($resolver) {
        return ($this['resolver'] === $resolver or (strpos($this['resolver'], $resolver) !== false));
    }

    public function log($level, $message, array $context = [])
    {
        return $this['logger']->log($level, $message, $context);
    }

    public function redirect($url, $status = 302)
    {
        $this['response'] = new RedirectResponse($url, $status);
        $this->finish();
    }

    public function setup()
    {
        if (null === $this['site']) {
            throw new Exception\SiteNotFoundException;
        }

        $constants = (new \ReflectionClass('\\CMS\\Pages'))->getConstants();
        $dispatcher = $this['event.dispatcher'];

        foreach($constants as $class => $event) {
            $class = str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower($class))));
            $class = '\\CMS\\EventSubscriber\\'.$class.'PageSubscriber';
            $subscriber = new $class($this);
            $dispatcher->addSubscriber($subscriber);
        }

        $segments = array_slice(explode('/', $this['uri'], 4), 1, 3);
        $resolver = strtoupper(implode('_', $segments));

        $resolver == '' and $resolver = 'HOME';

        if ($segments[0] == 'admin') {
            $this['resolver'] = \CMS\Pages::ADMIN;
        } else {
            if (defined('\\CMS\\Pages::'.$resolver)) {
                $this['resolver'] = constant('\\CMS\\Pages::'.$resolver);
            } else {
                $this['resolver'] = \CMS\Pages::PAGE;
            }
        }
    }

    private function _encrypt($string)
    {
        return md5($string);
    }
}