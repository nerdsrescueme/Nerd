<?php

namespace CMS\Entity;

/**
 * @Entity(repositoryClass="CMS\Entity\Repository\PostRepository")
 * @Table(name="nerd_posts")
 */
class Post
{
  use Traits\Identified;
  use Traits\Timestamped;
  use Traits\Sited;
  use Traits\Usered;

    /**
     * @Id
     * @Column(type="integer", scale=7, nullable=false)
     * @GeneratedValue
     */
    private $id;

    /**
     * Overload site property from trait
     * 
     * @ManyToOne(targetEntity="Site", inversedBy="pages")
     * @JoinColumn(name="site_id", referencedColumnName="id")
     */
    private $site;

    /**
     * @Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @Column(type="text", nullable=false)
     */
    private $excerpt;

    /**
     * @Column(type="text", nullable=false)
     */
    private $data;

    /**
     * @Column(type="string", length=16, nullable=false)
     */
    private $status = 'one';

    /**
     * @ManyToMany(targetEntity="Keyword", inversedBy="post")
     * @JoinTable(name="nerd_post_keywords")
     */
    private $keywords;

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