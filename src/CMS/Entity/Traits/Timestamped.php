<?php

namespace CMS\Entity\Traits;

use DateTime as PHPDateTime;

trait Timestamped
{

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Ext\Timestampable(on="create")
     * @Assert\DateTime
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     * @Ext\Timestampable(on="update")
     * @Assert\DateTime
     */
    protected $updatedAt;

    /**
     * Returns creation datetime object
     * 
     * @return DateTime Date on which entity was created
     */
	public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set entity creation date
     * 
     * @param DateTime $datetime Creation date
     * @return void
     */
    public function setCreatedAt(PHPDateTime $datetime)
    {
    	$this->createdAt = $datetime;
    }

    /**
     * Returns last update datetime object
     * 
     * @return DateTime Date on which entity was last updated
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set entity last update date
     * 
     * @param DateTime $datetime Last updated date
     * @return void
     */
    public function setUpdatedAt(PHPDateTime $datetime)
    {
    	$this->updatedAt = $datetime;
    }
}