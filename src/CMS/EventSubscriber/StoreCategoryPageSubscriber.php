<?php

namespace CMS\EventSubscriber;

use CMS\Application;
use CMS\Pages;
use CMS\Event\PageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StoreCategoryPageSubscriber extends BasePageSubscriber
{
	public function onStoreCategory(PageEvent $event)
	{
		// Do something with the blog response.
	}

	public static function getSubscribedEvents()
	{
		return array(
			Pages::STORE_CATEGORY => 'onStoreCategory',
		);
	}
}