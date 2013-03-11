<?php

namespace CMS\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Secs\UserInterface;
use Secs\RoleInterface;
use Secs\PermissionInterface;
use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="CMS\Entity\Repository\UserRepository")
 * @ORM\Table(name="nerd_users")
 */
class User implements UserInterface
{
    // Constants
    const STATUS_DEFAULT  = 'inactive';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_ACTIVE   = 'active';
    const STATUS_BANNED   = 'banned';

    const LEVEL_SUPER  = 'super';
    const LEVEL_ADMIN  = 'admin';
    const LEVEL_USER   = 'user';
    const LEVEL_GUEST  = 'guest';
    const LEVEL_BANNED = 'banned';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", scale=5, nullable=false)
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $super = false;

    /**
     * @ORM\Column(type="string", length=32, nullable=false)
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=81, nullable=false)
     */
    protected $password;

    /**
     * @ORM\Column(name="salt", type="string", length=81, nullable=true)
     */
    protected $salt;

    /**
     * @ORM\Column(name="temp_password", type="string", length=81, nullable=true)
     */
    protected $tempPassword;

    /**
     * @ORM\Column(type="string", length=81, nullable=true)
     */
    protected $remember;

    /**
     * @ORM\Column(name="activation_hash", type="string", length=81, nullable=true)
     */
    protected $activationHash;

    /**
     * @ORM\Column(type="string", length=45, nullable=false)
     */
    protected $ip;

    /**
     * @ORM\Column(name="last_login", type="datetime", nullable=false)
     */
    protected $lastLogin;

    /**
     * @ORM\Column(type="string", length=16, nullable=false)
     */
    protected $status = self::STATUS_DEFAULT;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $activated = false;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    protected $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity="CMS\Entity\User\Metadata")
     * @ORM\JoinColumn(name="id", referencedColumnName="user_id")
     */
    protected $metadata;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     * @ORM\JoinTable(name="nerd_users_roles")
     */
    protected $roles;

    protected $permissionsCache;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if ($this->id !== null) {
            throw new \RuntimeException('Id cannot be reset');
        }

        if (!is_int($id)) {
            throw new \InvalidArgumentException('Id must be an integer');
        }

        $this->id = $id;
    }

    public function isSuper()
    {
        return (bool) $this->super;
    }

    public function setSuper($super = true)
    {
        if (!is_bool($super)) {
            throw new \InvalidArgumentException('Super must be a boolean value');
        }

        $this->super = $super;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email is not a valid email value');
        }

        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getTempPassword()
    {
        return $this->tempPassword;
    }

    public function setTempPassword($tempPassword)
    {
        $this->tempPassword = $tempPassword;
    }

    public function getRemember()
    {
        return $this->remember;
    }

    public function setRemember($remember)
    {
        $this->remember = $remember;
    }

    public function getActivationHash()
    {
        return $this->activationHash;
    }

    public function setActivationHash($activationHash)
    {
        $this->activationHash = $activationHash;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setIp($ip)
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            throw new \InvalidArgumentException('IP is invalid');
        }

        $this->ip = $ip;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getStatuses()
    {
        return [
            self::STATUS_DEFAULT,
            self::STATUS_INACTIVE,
            self::STATUS_ACTIVE,
            self::STATUS_BANNED,
        ];
    }

    public function setStatus($status)
    {
        if (!in_array($status, $this->getStatuses())) {
            throw new \InvalidArgumentException('Invalid status');
        }

        $this->status = $status;
    }

    public function isActivated()
    {
        return (bool) $this->activated;
    }

    public function setActive()
    {
        $this->activated = true;
    }

    public function setInactive()
    {
        $this->activated = false;
    }

    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    // Validate datetime
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    public function isBanned()
    {
        return $this->getStatus() === self::STATUS_BANNED;
    }

    /**
     * Metadata association
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Role association
     */
    public function getRoles()
    {
        return $this->roles;
    }

    public function hasRole(RoleInterface $role)
    {
        return $this->roles->contains($role);
    }

    /**
     * Permission association by proxy
     */
    public function getPermissions()
    {
        $permissions = new ArrayCollection();
        foreach ($this->getRoles() as $role) {
            foreach ($role->getPermissions() as $perm) {
                $permissions->add($perm);
            }
        }

        return $permissions;
    }

    public function hasPermission(PermissionInterface $permission)
    {
        foreach ($this->getRoles() as $role) {
            if ($role->hasPermission($permission)) return true;
        }

        return false;
    }
}
