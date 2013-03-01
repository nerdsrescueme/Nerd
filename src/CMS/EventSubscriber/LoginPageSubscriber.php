<?php

namespace CMS\EventSubscriber;

use CMS\Application;
use CMS\Pages;
use CMS\Event\PageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LoginPageSubscriber extends BasePageSubscriber
{
	public function onLogin(PageEvent $event)
	{
		if ($this->app['post']->get('login', false)) {
            $email    = $this->app['post']->get('email');
            $password = $this->app['post']->get('password');
            $remember = (bool) $this->app['post']->get('remember', false);
            $result   = $this->app->authenticate($email, $password);

            $this->app->redirect($result ? '/' : '/login');
        }

        $this->app->deauthenticate();
        $page = $this->app['db.page']->getOneByUri('@@LOGIN');
        $event->setPage($page);
	}

	public static function getSubscribedEvents()
	{
		return array(
			Pages::LOGIN => 'onLogin',
		);
	}
}