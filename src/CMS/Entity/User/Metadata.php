<?php

namespace CMS\Entity\User;

use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="nerd_user_metadata")
 */
class Metadata
{
    /**
	 * @ORM\Id
	 * @ORM\Column(name="user_id", type="integer", scale=5, nullable=false)
	 */
	protected $userId;

    /**
     * @ORM\Column(name="first_name", type="string", length=36, nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", length=36, nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="integer", length=5, nullable=true)
     */
    protected $zip;


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