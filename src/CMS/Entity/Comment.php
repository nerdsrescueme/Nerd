<?php

namespace CMS\Entity;

use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment entity
 * 
 * @ORM\Entity
 * @ORM\Table(name="nerd_comments")
 * @ORM\HasLifecycleCallbacks
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="type", type="integer")
 * @DiscriminatorMap({1="PostComment", 2="ProductComment", 3="PageComment"})
 * 
 * @package NerdCMS
 * @category Entities
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
class Comment
{
    use Traits\Timestamped;
    use Traits\Identified;

    const TYPE_POST    = 1; // Blog posts
    const TYPE_PRODUCT = 2; // Products
    const TYPE_PAGE    = 3; // Pages

    const STATUS_DEFAULT = 1;
    const STATUS_DELETED = 0;
    const STATUS_UNAPPROVED = 1;
    const STATUS_SPAM = 2;
    const STATUS_APPROVED = 10;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", scale=10, nullable=false)
     * @ORM\GeneratedValue
     */
	protected $id;

    /**
     * @ORM\Column(type="integer", scale=2, nullable=false)
     * @Assert\Choice(callback="getTypes")
     * @Assert\NotBlank
     */
    protected $type;

    /**
     * @ORM\Column(name="parent_id", type="integer", scale=10, nullable=false)
     * @Assert\NotBlank
     */
    protected $parentId;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Assert\Choice(callback="getStatuses")
     * @Assert\NotBlank
     */
    protected $status = self::STATUS_DEFAULT;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Assert\MinLength(min=3)
     * @Assert\NotBlank
     */
    protected $data;


    public function getType()
    {
        return $this->type;
    }

    public function getTypes()
    {
        return [
            self::TYPE_POST,
            self::TYPE_PRODUCT,
            self::TYPE_PAGE,
        ];
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getStatuses()
    {
        return [
            self::STATUS_DEFAULT,
            self::STATUS_APPROVED,
            self::STATUS_SPAM,
            self::STATUS_UNAPPROVED,
            self::STATUS_DELETED,
        ];
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }
}