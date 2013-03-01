<?php

namespace CMS\EventSubscriber;

use CMS\Application;
use CMS\Pages;
use CMS\Event\PageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BlogHomePageSubscriber extends BasePageSubscriber
{
	public function onBlogHome(PageEvent $event)
	{
		// Do something with the blog response.
	}

	public static function getSubscribedEvents()
	{
		return array(
			Pages::BLOG_HOME => 'onBlogHome',
		);
	}
}