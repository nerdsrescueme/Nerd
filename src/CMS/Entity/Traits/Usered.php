<?php

namespace CMS\Entity\Traits;

use CMS\Entity\User;

trait Usered
{
	/**
     * @Column(name="user_id", type="integer", scale=5, nullable=false)
     */
    private $userId;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * Explicitly set user id association
     * 
     * @todo Remove validation check when scalar type hinting hits
     * 
     * @param integer $userId ID of the user to associate
     * @throws InvalidArgumentException If $userId is not an integer value
     * @return void
     */
    public function setUserId($userId)
    {
        if (!is_int($userId)) {
            throw new \InvalidArgumentException('Invalid type: User ID must be an integer ['.gettype($userId).'] given');
        }

        $this->userId = $userId;
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