<?php

namespace CMS\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Post entity
 * 
 * @ORM\Entity(repositoryClass="CMS\Entity\Repository\PostRepository")
 * @ORM\Table(name="nerd_posts")
 * @ORM\HasLifecycleCallbacks
 * 
 * @package NerdCMS
 * @category Entities
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
class Post
{
    use Traits\Identified;
    use Traits\Timestamped;
    use Traits\Sited;
    use Traits\Usered;
    use Traits\Keywordable;

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
     * @ORM\Column(type="integer", scale=7, nullable=false)
     * @ORM\GeneratedValue
     * 
     * @var integer
     */
    protected $id;

    /**
     * Overload site property from trait
     * 
     * @ORM\ManyToOne(targetEntity="Site", inversedBy="pages")
     * @ORM\JoinColumn(name="site_id", referencedColumnName="id")
     * @Assert\NotBlank
     * @Assert\Type(type="object")
     * 
     * @var Site
     */
    protected $site;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=3, max=155)
     * 
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Assert\MaxLength(limit=400)
     * 
     * @var string
     */
    protected $excerpt;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(min=4, max=4000)
     * 
     * @var string
     */
    protected $data;

    /**
     * @ORM\Column(type="integer", length=2, nullable=false)
     * @Assert\Choice(callback="getStatuses")
     * 
     * @var string
     */
    protected $status = self::STATUS_DEFAULT;

    /**
     * @ORM\ManyToMany(targetEntity="Keyword", inversedBy="post")
     * @ORM\JoinTable(name="nerd_post_keywords")
     * 
     * @var ArrayCollection
     */
    protected $keywords;

    public function __construct()
    {
        $this->keywords = new ArrayCollection();
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getExcerpt()
    {
        return $this->excerpt;
    }

    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getStatus()
    {
        return $this->status;
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

    public function setStatus($status)
    {
        $this->status = $status;
    }
}