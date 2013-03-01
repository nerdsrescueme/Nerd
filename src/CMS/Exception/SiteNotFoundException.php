<?php

namespace CMS\Exception;

class SiteNotFoundException extends \CMS\Exception
{
	protected $code = 100;
	protected $message = 'Site not found';
}