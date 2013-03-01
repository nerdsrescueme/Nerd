<?php

namespace CMS\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(readOnly=true)
 * @Table(name="nerd_page_history")
 */
class PageHistory
{
	/**
	 * @Id
	 * @Column(name="page_id", type="integer", scale=8, nullable=false)
	 */
	private $pageId;

	/**
	 * @Column(name="site_id", type="integer", scale=2, nullable=false)
	 */
	private $siteId;

	/**
	 * @Column(type="string", length=160, nullable=false)
	 */
	private $title;

	/**
	 * @Column(type="string", length=160, nullable=true)
	 */
	private $subtitle;

	/**
	 * @Column(type="string", length=200, nullable=false, unique=true)
	 */
	private $uri;

	/**
	 * @Column(type="string", length=200, nullable=true)
	 */
	private $description;

	/**
	 * @Column(type="string", length=16, nullable=true)
	 */
	private $status = 'one';

	/**
	 * @Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt;


	public function getPageId()
	{
		return $this->id;
	}

	public function getSiteId()
	{
		return $this->siteId;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getSubtitle()
	{
		return $this->subtitle;
	}

	public function getUri()
	{
		return $this->uri;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}
}