<?php

namespace CMS\Entity;

/**
 * @Entity(repositoryClass="CMS\Entity\Repository\SessionRepository")
 * @Table(name="nerd_sessions")
 */
class Session
{
	/**
	 * @Id
	 * @Column(type="string", length=50, nullable=true)
	 */
	private $id;

	/**
	 * @Column(type="string", nullable=false)
	 */
	private $data;

	/**
	 * @Column(name="created_at", type="datetime", nullable=true)
	 */
	private $createdAt;

	/**
	 * @Column(name="updated_at", type="datetime", nullable=true)
	 */
	private $updatedAt;


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