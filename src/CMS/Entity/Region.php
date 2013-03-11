<?php

namespace CMS\Entity;

use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="nerd_regions")
 */
class Region
{
	use Traits\Identified;
	use Traits\Regioned;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", scale=8, nullable=false)
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * Overload trait default property
	 * 
	 * @ORM\ManyToOne(targetEntity="Page", inversedBy="regions")
	 * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
	 */
	protected $page;
}