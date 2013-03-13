<?php

namespace CMS\Entity;

use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Page comment entity
 * 
 * @ORM\Entity
 * @ORM\Table(name="nerd_comments")
 * @ORM\HasLifecycleCallbacks
 * 
 * @package NerdCMS
 * @category Entities
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
class PageComment
{
    /**
     * @ORM\Column(type="integer", scale=2, nullable=false)
     * @Assert\Choice(callback="getTypes")
     * @Assert\NotBlank
     */
    protected $type = self::TYPE_PAGE;

    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="comments")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $page;

    /**
     * Return associated page entity
     *
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set associated page entity
     *
     * @param Page $page Page entity
     * @return void
     */
    public function setPage(Page $page)
    {
        $this->page = $page;
    }
}