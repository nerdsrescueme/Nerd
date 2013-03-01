<?php

namespace CMS\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Secs\PermissionInterface;

/**
 * @Entity(repositoryClass="CMS\Entity\Repository\PermissionRepository")
 * @Table(name="nerd_permissions")
 */
class Permission implements PermissionInterface
{
    /**
     * @Id
     * @Column(type="integer", scale=4, nullable=false)
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string", length=32, nullable=false)
     */
    private $name;

    /**
     * @Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ManyToMany(targetEntity="Role", mappedBy="permissions")
     */
    private $roles;


    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Role association
     */
    public function getRoles()
    {
        return $this->roles;
    }
}