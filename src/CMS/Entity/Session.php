<?php

namespace CMS\Entity;

use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="CMS\Entity\Repository\SessionRepository")
 * @ORM\Table(name="nerd_sessions")
 * @ORM\HasLifecycleCallbacks
 * 
 * @package NerdCMS
 * @category Entities
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
class Session
{
	use Traits\Timestamped;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="string", length=50, nullable=true)
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected $data;


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
}