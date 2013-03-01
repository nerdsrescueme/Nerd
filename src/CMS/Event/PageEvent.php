<?php

namespace CMS\Event;

use Symfony\Component\EventDispatcher\Event;
use CMS\Entity\Page;

class PageEvent extends Event
{
	protected $page;
	protected $data = [];

	public function setPage(Page $page)
	{
		$this->page = $page;
	}

	public function getPage()
	{
		return $this->page;
	}

	public function setData(array $data)
	{
		$this->data = $data;
	}

	public function getData()
	{
		return $this->data;
	}
}