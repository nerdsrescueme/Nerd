<?php

namespace CMS\EventSubscriber;

use CMS\Application;
use CMS\Pages;
use CMS\Event\PageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PagePageSubscriber extends BasePageSubscriber
{
	public function onPage(PageEvent $event)
	{
		$page = $this->app['db.page']->getOneByUri($this->app['request']->getPathInfo());
		$event->setPage($page);
	}

	public static function getSubscribedEvents()
	{
		return array(
			Pages::PAGE => 'onPage',
		);
	}
}