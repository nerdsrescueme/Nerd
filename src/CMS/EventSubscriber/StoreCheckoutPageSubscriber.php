<?php

namespace CMS\EventSubscriber;

use CMS\Application;
use CMS\Pages;
use CMS\Event\PageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StoreCheckoutPageSubscriber extends BasePageSubscriber
{
	public function onStoreCheckout(PageEvent $event)
	{
		// Do something with the blog response.
	}

	public static function getSubscribedEvents()
	{
		return array(
			Pages::STORE_CHECKOUT => 'onStoreCheckout',
		);
	}
}