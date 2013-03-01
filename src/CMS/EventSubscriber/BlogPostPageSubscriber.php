<?php

namespace CMS\EventSubscriber;

use CMS\Application;
use CMS\Pages;
use CMS\Event\PageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BlogPostPageSubscriber extends BasePageSubscriber
{
	public function onBlogPost(PageEvent $event)
	{
		// Do something with the blog response.
	}

	public static function getSubscribedEvents()
	{
		return array(
			Pages::BLOG_POST => 'onBlogPost',
		);
	}
}