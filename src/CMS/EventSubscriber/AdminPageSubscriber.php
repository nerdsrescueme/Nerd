<?php

namespace CMS\EventSubscriber;

use CMS\Application;
use CMS\Pages;
use CMS\Event\PageEvent;
use CMS\Page\Admin;
use CMS\Entities\Page;
use CMS\Exception\RouteNotFoundException;
use CMS\Exception\ControllerNotFoundException;
use CMS\Exception\ActionNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Aura\Router\Route;

class AdminPageSubscriber extends BasePageSubscriber
{
	public function onAdmin(PageEvent $event)
	{
		$route = $this->_resolveRoute();
		$controller = $this->_resolveController($route);
		$method = $this->_resolveMethod($controller);

		$controller->before();
		$controller->{$method}();
		$controller->after();

		$event->setPage($controller->getPage());
		$event->setData($controller->getData());
	}

	private function _resolveRoute()
	{
		$route = $this->app['router']->match($this->app['uri'], $_SERVER);

		if (!$route) {
			throw new RouteNotFoundException;
		}

		return $route;
	}

	private function _resolveController(Route $route)
	{
		try {
			$controller = '\\CMS\\Controller\\'.ucfirst($route->values['controller']).'Controller';
			$controller = new $controller($this->app, $route);
		} catch (\Exception $e) {
			throw new ControllerNotFoundException;
		}

		return $controller;
	}

	private function _resolveMethod($controller)
	{
		$action = $controller->getRoute()->values['action'];
		$method = "{$action}Action";

		if (!method_exists($controller, $method))
		{
			throw new ActionNotFoundException;
		}

		return $method;
	}

	public static function getSubscribedEvents()
	{
		return array(
			Pages::ADMIN => 'onAdmin',
		);
	}
}