<?php

namespace CMS\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Secs\RoleInterface;
use Secs\PermissionInterface;
use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="CMS\Entity\Repository\RoleRepository")
 * @ORM\Table(name="nerd_roles")
 * 
 * @package NerdCMS
 * @category Entities
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
class Role implements RoleInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", scale=4, nullable=false)
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=32, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $description;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="roles")
     */
    protected $users;

    /**
	 * @ORM\ManyToMany(targetEntity="Permission", inversedBy="roles", fetch="EAGER")
     * @ORM\JoinTable(name="nerd_roles_permissions")
     */
    protected $permissions;


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