<?php

namespace CMS\Entity;

/**
 * @Entity
 * @Table(name="nerd_regions")
 */
class Region
{
	use Traits\Identified;
	use Traits\Regioned;

	/**
	 * @Id
	 * @Column(type="integer", scale=8, nullable=false)
	 * @GeneratedValue
	 */
	private $id;

	/**
	 * Overload trait default property
	 * 
	 * @ManyToOne(targetEntity="Page", inversedBy="regions")
	 * @JoinColumn(name="page_id", referencedColumnName="id")
	 */
	private $page;
}