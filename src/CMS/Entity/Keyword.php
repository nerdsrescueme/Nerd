<?php

namespace CMS\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Keyword entity
 * 
 * @ORM\Entity
 * @ORM\Table(name="nerd_keywords")
 * 
 * @package NerdCMS
 * @category Entities
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
class Keyword
{
    /**
	 * @ORM\Id
	 * @ORM\Column(type="integer", scale=11, nullable=false)
	 * @ORM\GeneratedValue
	 */
	protected $id;

    /**
     * @ORM\Column(type="string", length=32, nullable=false, unique=true)
     * @Assert\NotBlank
     * @Assert\Length(min=2, max=32)
     */
    protected $keyword;

    /**
     * @ORM\ManyToMany(targetEntity="Page", mappedBy="keywords")
     */
    protected $pages;

    /**
     * Constructor
     * 
     * @return this
     */
    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    /**
     * Return keyword id
     * 
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return keyword
     * 
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Get associated page entities
     * 
     * @return array[Page]
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set keyword
     * 
     * @param string $keyword Keyword
     * @return void
     */
    public function setKeyword($keyword)
    {
        $this->keyword = trim($keyword);
    }

    /**
     * String object representation
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getKeyword();
    }
}