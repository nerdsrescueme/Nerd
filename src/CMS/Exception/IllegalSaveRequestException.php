<?php

namespace CMS\Exception;

class IllegalSaveRequestException extends \CMS\Exception
{
	protected $code = 300;
	protected $message = 'Illegal save request';
}