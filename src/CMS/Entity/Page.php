<?php

namespace CMS\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Page entity
 *
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
     * @Assert\Length(min=3, max=32)
     * @Assert\NotBlank
     */
    protected $layout = 'default';

    /**
     * @ORM\Column(type="string", length=160, nullable=false)
     * @Assert\Length(min=3, max=160)
     * @Assert\NotBlank
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=160, nullable=true)
     * @Assert\Length(min=3, max=32)
     */
    protected $subtitle;

    /**
     * @ORM\Column(type="string", length=200, nullable=false, unique=true)
     * @Assert\Length(min=2, max=200)
     * @Assert\NotBlank
     */
    protected $uri;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @Assert\Length(min=3, max=200)
     */
    protected $description;

    /**
     * @ORM\Column(type="integer", length=2, nullable=true)
     * @Assert\Choice(callback="getStatuses")
     */
    protected $status = self::STATUS_DEFAULT;

    /**
     * @ORM\Column(type="integer", scale=2, nullable=false)
     * 
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

    /**
     * Constructor
     *
     * @return this
     */
    public function __construct()
    {
        $this->keywords = new ArrayCollection();
        $this->regions = new ArrayCollection();
    }

    /**
     * Return page change frequency
     *
     * @return integer
     */
    public function getChangeFrequency()
    {
        return $this->changeFrequency;
    }

    /**
     * Return all available change frequencies
     *
     * @return array[integer]
     */
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

    /**
     * Return page description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Return page layout
     *
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Return associated region entities
     *
     * @return array[Region]
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * Return associated region entity by name
     *
     * @return Region
     */
    public function getRegion($name)
    {
        foreach ($this->getRegions() as $region) {
            if ($region->getKey() == $name) {
                return $region;
            }
        }
    }

    /**
     * Return page status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Return available page statuses
     *
     * @return array[integer]
     */
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

    /**
     * Return page subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Return page title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Return page uri
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }


    public function setLayout($layout)
    {
        $this->layout = trim($layout);
    }

    public function setTitle($title)
    {
        $this->title = trim($title);
    }

    public function setSubtitle($subtitle)
    {
        $this->subtitle = trim($subtitle);
    }

    public function setUri($uri)
    {
        $this->uri = trim($uri, '/');
    }

    public function setDescription($description)
    {
        $this->description = trim($description);
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setChangeFrequency($frequency)
    {
        if (!in_array($frequency, $this->getChangeFrequencies())) {
            throw new \InvalidArgumentException('Invalid change frequency');
        }

        $this->changeFrequency = $frequency;
    }

    public function addRegion(Region $region)
    {
        $region->setPage($this);
        $this->regions[] = $region;
    }
}
