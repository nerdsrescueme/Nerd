<?php

namespace CMS\Entity;

/**
 * @Entity
 * @Table(name="nerd_comments")
 */
class Comment
{
    use Traits\Timestamped;
    use Traits\Identifiable;

    const TYPE_POST    = 1; // Blog posts
    const TYPE_PRODUCT = 2; // Products

    /**
     * @Id
     * @Column(type="integer", scale=10, nullable=false)
     * @GeneratedValue
     */
	protected $id;

    /**
     * @Column(name="type_id", type="integer", scale=2, nullable=false)
     */
    protected $typeId;

    /**
     * @Column(name="parent_id", type="integer", scale=10, nullable=false)
     */
    protected $parentId;

    /**
     * @Column(type="string", length=16, nullable=true)
     */
    protected $status = 'one';

    /**
     * @Column(type="text", nullable=false)
     */
    protected $data;

    public function getTypeId()
    {
        return $this->typeId;
    }

    public function getParentId()
    {
        return $this->parentId();
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getData()
    {
        return $this->data;
    }
}