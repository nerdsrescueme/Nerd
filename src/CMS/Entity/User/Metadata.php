<?php

namespace CMS\Entity\User;

/**
 * @Entity
 * @Table(name="nerd_user_metadata")
 */
class Metadata
{
    /**
	 * @Id
	 * @Column(name="user_id", type="integer", scale=5, nullable=false)
	 */
	private $userId;

    /**
     * @Column(name="first_name", type="string", length=36, nullable=true)
     */
    private $firstName;

    /**
     * @Column(name="last_name", type="string", length=36, nullable=true)
     */
    private $lastName;

    /**
     * @Column(type="integer", length=5, nullable=true)
     */
    private $zip;


    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    // Make association to nerd_cities;
    public function getZip()
    {
        return $this->zip;
    }
}