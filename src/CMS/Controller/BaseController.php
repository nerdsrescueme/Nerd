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
	protected $post;
	protected $get;

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
		$this->post = $this->request->request;
		$this->get = $this->request->query;

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

	public function save($object)
	{
		return $this->app['db']->persist($object);
	}

	public function validate($object)
	{
		return $this->app['validator']->validate($object);
	}

	public function getData($key = null)
	{
		return $key ? $this->data[$key] : $this->data;
	}

	public function isPost()
	{
		return $this->request->isMethod('post');
	}

	public function addData($key, $value)
	{
		$this->data[$key] = $value;
	}
}