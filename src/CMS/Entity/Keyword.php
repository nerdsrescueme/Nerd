<?php

namespace CMS\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="nerd_keywords")
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
     */
    protected $keyword;

    /**
     * @ORM\ManyToMany(targetEntity="Page", mappedBy="keywords")
     */
    protected $pages;


    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    public function getKeyword()
    {
        return $this->keyword;
    }

    public function __toString()
    {
        return $this->getKeyword();
    }
}