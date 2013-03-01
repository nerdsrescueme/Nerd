<?php

namespace CMS\EventSubscriber;

use CMS\Application;
use CMS\Pages;
use CMS\Event\PageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BlogPageSubscriber extends BasePageSubscriber
{
	public function onBlog(PageEvent $event)
	{
		$page = $this->app['db.page']->getOneByUri('@@BLOG');
		$event->setPage($page);
	}

	public static function getSubscribedEvents()
	{
		return array(
			Pages::BLOG => 'onBlog',
		);
	}
}