<?php

namespace CMS\Entity\Traits;

use CMS\Entity\User;

trait Usered
{
	/**
     * @ORM\Column(name="user_id", type="integer", scale=5, nullable=false)
     */
    protected $userId;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * Returns associated user id
     * 
     * @return integer ID of the user to which this page is associated
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Returns associated user object
     * 
     * @return User User entity object
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * User entity association
     * 
     * @param User $user Entity object of the user to associate
     * @return void
     */
    public function setUser(User $user)
    {
    	$this->user = $user;
    }
}