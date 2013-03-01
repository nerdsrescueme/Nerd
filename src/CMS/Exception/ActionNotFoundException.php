<?php

namespace CMS\Exception;

class ActionNotFoundException extends \CMS\Exception
{
	protected $code = 202;
	protected $message = 'Action not found';
}