<?php

namespace CMS\Entity;

use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="CMS\Entity\Repository\SessionRepository")
 * @ORM\Table(name="nerd_sessions")
 */
class Session
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="string", length=50, nullable=true)
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected $data;

	/**
	 * @ORM\Column(name="created_at", type="datetime", nullable=true)
	 */
	protected $createdAt;

	/**
	 * @ORM\Column(name="updated_at", type="datetime", nullable=true)
	 */
	protected $updatedAt;


	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		if ($this->id !== null) {
			throw new \RuntimeException('Id cannot be reset');
		}

		$this->id = $id;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function setCreatedAt()
	{
		throw new \RuntimeException('Created at is automatically set by the database');
	}

	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt()
	{
		throw new \RuntimeException('Updated at is automatically set by the database');
	}
}