<?php

namespace CMS\Exception;

class RouteNotFoundException extends \CMS\Exception
{
	protected $code = 200;
	protected $message = 'No matching route found';
}