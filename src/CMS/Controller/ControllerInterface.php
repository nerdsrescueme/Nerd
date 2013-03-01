<?php

namespace CMS\Controller;

use CMS\Application;
use Aura\Router\Route;

interface ControllerInterface
{
	public function __construct(Application $app, Route $route);

	public function before();

	public function after();
}