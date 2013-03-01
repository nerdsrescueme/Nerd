<?php

namespace CMS\EventSubscriber;

use CMS\Application;
use CMS\Pages;
use CMS\Event\PageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LogoutPageSubscriber extends BasePageSubscriber
{
	public function onLogout(PageEvent $event)
	{
		$this->app->deauthenticate();
        $this->app->redirect('/');
	}

	public static function getSubscribedEvents()
	{
		return array(
			Pages::LOGOUT => 'onLogout',
		);
	}
}