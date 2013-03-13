<?php

namespace CMS\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="CMS\Entity\Repository\PageRepository")
 * @ORM\Table(name="nerd_pages")
 * @ORM\HasLifecycleCallbacks
 * 
 * @package NerdCMS
 * @category Entities
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
class Page
{
    use Traits\Identified;
    use Traits\Sited;
    use Traits\Timestamped;

    // Change frequencies
    const FREQ_DEFAULT = 5;
    const FREQ_ALWAYS  = 2;
    const FREQ_HOURLY  = 3;
    const FREQ_DAILY   = 4;
    const FREQ_WEEKLY  = 5;
    const FREQ_MONTHLY = 6;
    const FREQ_YEARLY  = 7;
    const FREQ_NEVER   = 0;

    const STATUS_DEFAULT = 6;
    const STATUS_PUBLISHED = 9;
    const STATUS_FUTURE = 8;
    const STATUS_DRAFT = 7;
    const STATUS_PENDING = 6;
    const STATUS_PRIVATE = 5;
    const STATUS_AUTODRAFT = 4;
    const STATUS_INHERIT = 3;
    const STATUS_TRASH = 0;

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
     * @ORM\Column(type="integer", length=2, nullable=true)
     * @Assert\Choice(callback="getStatuses")
     */
    protected $status = self::STATUS_DEFAULT;

    /**
     * @ORM\Column(type="integer", scale=2, nullable=false)
     */
    protected $priority = 5;

    /**
     * @ORM\Column(name="change_frequency", type="integer", length=2, nullable=false)
     * @Assert\Choice(callback="getChangeFrequencies")
     */
    protected $changeFrequency = self::FREQ_DEFAULT;

    /**
     * @ORM\ManyToMany(targetEntity="Keyword", inversedBy="page")
     * @ORM\JoinTable(name="nerd_page_keywords")
     */
    protected $keywords;

    /**
     * @ORM\OneToMany(targetEntity="Region", mappedBy="page")
     */
    protected $regions;

    public function __construct()
    {
        $this->keywords = new ArrayCollection();
        $this->regions = new ArrayCollection();
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

    public function getStatuses()
    {
        return [
            self::STATUS_PUBLISHED,
            self::STATUS_FUTURE,
            self::STATUS_DRAFT,
            self::STATUS_PENDING,
            self::STATUS_PRIVATE,
            self::STATUS_AUTODRAFT,
            self::STATUS_INHERIT,
            self::STATUS_TRASH,
        ];
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
