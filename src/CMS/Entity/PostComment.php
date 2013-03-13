<?php

namespace CMS\Entity;

use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Post comment entity
 * 
 * @ORM\Entity
 * @ORM\Table(name="nerd_comments")
 * @ORM\HasLifecycleCallbacks
 * 
 * @package NerdCMS
 * @category Entities
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
class PostComment
{
    /**
     * @ORM\Column(type="integer", scale=2, nullable=false)
     * @Assert\Choice(callback="getTypes")
     * @Assert\NotBlank
     */
    protected $type = self::TYPE_POST;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $post;

    /**
     * Return associated post entity
     *
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set associated post entity
     *
     * @param Post $post Post entity
     * @return void
     */
    public function setPost(Post $post)
    {
        $this->post = $post;
    }
}