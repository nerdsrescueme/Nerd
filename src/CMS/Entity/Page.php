<?php

namespace CMS\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="CMS\Entity\Repository\PageRepository")
 * @ORM\Table(name="nerd_pages")
 */
class Page
{
    use Traits\Identified;
    use Traits\Sited;
    use Traits\Timestamped;

    // Change frequencies
    const FREQ_DEFAULT = 'weekly';
    const FREQ_ALWAYS  = 'always';
    const FREQ_HOURLY  = 'hourly';
    const FREQ_DAILY   = 'daily';
    const FREQ_WEEKLY  = 'weekly';
    const FREQ_MONTHLY = 'monthly';
    const FREQ_YEARLY  = 'yearly';
    const FREQ_NEVER   = 'never';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", scale=8, nullable=false)
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * Injected site property for trait
     * 
     * @ORM\ManyToOne(targetEntity="Site", inversedBy="pages")
     * @ORM\JoinColumn(name="site_id", referencedColumnName="id")
     */
    protected $site;

    /**
     * @ORM\Column(type="string", length=32, nullable=false)
     */
    protected $layout = 'default';

    /**
     * @ORM\Column(type="string", length=160, nullable=false)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=160, nullable=true)
     */
    protected $subtitle;

    /**
     * @ORM\Column(type="string", length=200, nullable=false, unique=true)
     */
    protected $uri;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    protected $status = 'one';

    /**
     * @ORM\Column(type="integer", scale=2, nullable=false)
     */
    protected $priority = 5;

    /**
     * @ORM\Column(name="change_frequency", type="string", length=16, nullable=true)
     */
    protected $changeFrequency = self::FREQ_DEFAULT;

    /**
     * @ORM\ManyToMany(targetEntity="Keyword", inversedBy="page")
     * @ORM\JoinTable(name="nerd_page_keywords")
     */
    protected $keywords;

    ///**
    // * @ORM\OneToMany(targetEntity="Component", mappedBy="page")
    // */
    //protected $components;

    /**
     * @ORM\OneToMany(targetEntity="Region", mappedBy="page")
     */
    protected $regions;

    ///**
    // * @ORM\OneToMany(targetEntity="Snippet", mappedBy="page")
    // */
    //protected $snippets;

    public function __construct()
    {
        $this->keywords = new ArrayCollection();
        //$this->components = new ArrayCollection();
        $this->regions = new ArrayCollection();
        //$this->snippets = new ArrayCollection();
    }

    public function getLayout()
    {
        return $this->layout;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getSubtitle()
    {
        return $this->subtitle;
    }

    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = trim($uri, '/');
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        // Need to use enum prediction
        $this->status = $status;
    }

    public function getChangeFrequency()
    {
        return $this->changeFrequency;
    }

    public function getChangeFrequencies()
    {
        return [
            self::FREQ_ALWAYS,
            self::FREQ_HOURLY,
            self::FREQ_DAILY,
            self::FREQ_WEEKLY,
            self::FREQ_MONTHLY,
            self::FREQ_YEARLY,
            self::FREQ_NEVER,
        ];
    }

    public function setChangeFrequency($frequency)
    {
        if (!in_array($frequency, $this->getChangeFrequencies())) {
            throw new \InvalidArgumentException('Invalid change frequency');
        }

        $this->changeFrequency = $frequency;
    }

    /**
     * Keyword association
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    public function getKeywordsAsText()
    {
        $keywords = $this->getKeywords();
        $text = '';

        foreach ($keywords as $keyword) {
            $text .= $keyword->getKeyword().', ';
        }

        return substr($text, 0, -2);
    }

    /*
    public function getComponents()
    {
        return $this->components;
    }

    public function getComponent($name)
    {
        foreach ($this->getComponents() as $component) {
            if ($component->getKey() == $name) {
                return $component;
            }
        }
    }
    */

    /**
     * Region association
     */
    public function getRegions()
    {
        return $this->regions;
    }

    public function getRegion($name)
    {
        foreach ($this->getRegions() as $region) {
            if ($region->getKey() == $name) {
                return $region;
            }
        }
    }

    public function addRegion(Region $region)
    {
        $region->setPage($this);
        $this->regions[] = $region;
    }

    /*
    public function getSnippets()
    {
        return $this->snippets;
    }

    public function getSnippet($name)
    {
        foreach ($this->getSnippets() as $snippet) {
            if ($snippet->getKey() == $name) {
                return $snippet;
            }
        }
    }
    */
}
