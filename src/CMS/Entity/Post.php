<?php

namespace CMS\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="CMS\Entity\Repository\PostRepository")
 * @ORM\Table(name="nerd_posts")
 */
class Post
{
    use Traits\Identified;
    use Traits\Timestamped;
    use Traits\Sited;
    use Traits\Usered;

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
     * @ORM\Column(type="string", length=16, nullable=false)
     * @Assert\Choice(choices = {"one"}, message = "Choose a valid post status.")
     * 
     * @var string
     */
    protected $status = 'one';

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

    public function setStatus($status)
    {
        // Do status check!!!
        $this->status = $status;
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
}