<?php

namespace CMS\Controller;

use CMS\Application;
use CMS\Entity\Page;
use Aura\Router\Route;

abstract class BaseController implements ControllerInterface
{
	protected $app;
	protected $route;
	protected $request;
	protected $response;
	protected $page;
	protected $data;

	// Type route
	public function __construct(Application $app, Route $route)
	{
		$this->app = $app;
		$this->route = $route;
		$this->data = [];
	}

	public function before()
	{
		$this->request = $this->app['request'];
		$this->response = $this->app['response'];

		// Build a blank page object for controller to manipulate
		$this->page = new Page;
	}

	public function after()
	{
		
	}

	public function getRoute()
	{
		return $this->route;
	}

	public function getPage()
	{
		return $this->page;
	}

	public function getValidator()
	{
		return $this->app['validator'];
	}

	public function getData($key = null)
	{
		return $key ? $this->data[$key] : $this->data;
	}

	public function addData($key, $value)
	{
		$this->data[$key] = $value;
	}
}