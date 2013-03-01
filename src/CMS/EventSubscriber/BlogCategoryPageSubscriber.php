<?php

namespace CMS\EventSubscriber;

use CMS\Application;
use CMS\Pages;
use CMS\Event\PageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BlogCategoryPageSubscriber extends BasePageSubscriber
{
	public function onBlogCategory(PageEvent $event)
	{
		// Do something with the blog response.
	}

	public static function getSubscribedEvents()
	{
		return array(
			Pages::BLOG_CATEGORY => 'onBlogCategory',
		);
	}
}