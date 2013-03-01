<?php

namespace CMS\EventSubscriber;

use CMS\Application;
use CMS\Pages;
use CMS\Event\PageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HomePageSubscriber extends BasePageSubscriber
{
	public function onHome(PageEvent $event)
	{
		$page = $this->app['db.page']->getHome();
		$event->setPage($page);
	}

	public static function getSubscribedEvents()
	{
		return array(
			Pages::HOME => 'onHome',
		);
	}
}