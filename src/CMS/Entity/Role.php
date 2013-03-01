<?php

namespace CMS\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Secs\RoleInterface;
use Secs\PermissionInterface;

/**
 * @Entity(repositoryClass="CMS\Entity\Repository\RoleRepository")
 * @Table(name="nerd_roles")
 */
class Role implements RoleInterface
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
     * @ManyToMany(targetEntity="User", mappedBy="roles")
     */
    private $users;

    /**
	 * @ManyToMany(targetEntity="Permission", inversedBy="roles", fetch="EAGER")
     * @JoinTable(name="nerd_roles_permissions")
     */
    private $permissions;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Role association
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Permission association
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    public function hasPermission(PermissionInterface $permission) {
        foreach ($this->getPermissions() as $perm) {
			if ($permission instanceof Permission) {
                if ($permission === $perm->getName()) return true;
			} else {
				if ($permission === $perm) return true;
			}
		}

        return false;
    }
}