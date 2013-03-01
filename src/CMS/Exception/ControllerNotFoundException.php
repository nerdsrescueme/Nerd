<?php

namespace CMS\Exception;

class ControllerNotFoundException extends \CMS\Exception
{
	protected $code = 201;
	protected $message = 'Controller not found';
}