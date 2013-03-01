<?php

namespace CMS\EventSubscriber;

use CMS\Application;
use CMS\Pages;
use CMS\Event\PageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StorePageSubscriber extends BasePageSubscriber
{
	public function onStore(PageEvent $event)
	{
		$page = $this->app['db.page']->getOneByUri('@@STORE');
		$event->setPage($page);
	}

	public static function getSubscribedEvents()
	{
		return array(
			Pages::STORE => 'onStore',
		);
	}
}