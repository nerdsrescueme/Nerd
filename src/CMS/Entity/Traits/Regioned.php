<?php

namespace CMS\Entity\Traits;

use CMS\Entity\Page;

trait Regioned
{
	/**
	 * @ORM\Column(name="page_id", type="integer", scale=8, nullable=false)
	 */
	protected $pageId;

	/**
	 * @ORM\Column(name="`key`", type="string", length=32, nullable=false)
	 */
	protected $key;

	/**
	 * @ORM\Column(type="text", nullable=false)
	 */
	protected $data;

	/**
     * Returns associated page id
     * 
     * @return integer ID of page to which this entity is associated
     */
	public function getPageId()
	{
		return $this->pageId;
	}

	/**
     * Explicitly set page id association
     * 
     * @todo Remove validation check when scalar type hinting hits
     * 
     * @param integer $pageId ID of page to associate
     * @throws InvalidArgumentException If $pageId is not an integer value
     * @return void
     */
	public function setPageId($pageId)
	{
		if (!is_int($pageId)) {
            throw new \InvalidArgumentException('Invalid type: Page ID must be an integer ['.gettype($pageId).'] given');
        }

		$this->pageId = (int) $pageId;
	}

	/**
	 * Returns associated page object
	 * 
	 * @return Page Page entity object
	 */
	public function getPage()
	{
		return $this->page;
	}

	/**
	 * Page entity association
	 * 
	 * @param Page $page Page entity object
	 * @return void
	 */
	public function setPage(Page $page)
	{
		$this->page = $page;
	}

	/**
	 * Return key
	 * 
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * Set key
	 * 
	 * @param string $key
	 * @return void
	 */
	public function setKey($key)
	{
		$this->key = $key;
	}

	/**
	 * Return data
	 * 
	 * @return string
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Set data
	 * 
	 * @param string $data
	 * @return void
	 */
	public function setData($data)
	{
		$this->data = $data;
	}
}