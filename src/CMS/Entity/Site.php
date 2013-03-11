<?php

namespace CMS\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="nerd_sites")
 */
class Site
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", scale=2, nullable=false)
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=180, nullable=false)
	 */
	protected $host;

	/**
	 * @ORM\Column(type="string", length=32, nullable=false)
	 */
	protected $theme = 'default';

	/**
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	protected $active = 1;

	/**
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	protected $maintaining = 0;

	/**
	 * @ORM\Column(type="string", length=200, nullable=false)
	 */
	protected $description;

	/**
	 * @ORM\OneToMany(targetEntity="Page", mappedBy="site")
	 */
	protected $pages;

	/**
     * @ORM\ManyToMany(targetEntity="Keyword", inversedBy="sites")
     * @ORM\JoinTable(name="nerd_site_keywords")
     */
    protected $keywords;


	public function __construct()
	{
		$this->pages = new ArrayCollection();
		$this->keywords = new ArrayCollection();
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		if ($this->id !== null) {
			throw new \RuntimeException('Id cannot be reset');
		}

		if (!is_int($id)) {
			throw new \InvalidArgumentException('Id must be an integer');
		}

		$this->id = $id;
	}

	public function getHost()
	{
		return $this->host;
	}

	public function setHost($host)
	{
		if (!filter_var($host, FILTER_VALIDATE_URL)) {
			throw new \InvalidArgumentException('Host must be a valid URL');
		}

		$this->host = $host;
	}

	public function getTheme()
	{
		return $this->theme;
	}

	public function setTheme($theme)
	{
		$this->theme = $theme;
	}

	public function isActive()
	{
		return (bool) $this->active;
	}

	public function setActive()
	{
		$this->active = true;
	}

	public function setInactive()
	{
		$this->active = false;
	}

	public function isMaintaining()
	{
		return (bool) $this->maintaining;
	}

	public function setMaintaining($maintaining = true)
	{
		$this->maintaining = $maintaining;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * Page association
	 */
	public function getPages()
	{
		return $this->pages;
	}

	/**
	 * Keyword association
	 */
	public function getKeywords()
	{
		return $this->keywords;
	}

	public function getKeywordsAsString()
	{
		$keywords = '';

		foreach ($this->getKeywords() as $keyword) {
			$keywords .= $keyword.', ';
		}

		return substr($keywords, 0, -2);
	}
}