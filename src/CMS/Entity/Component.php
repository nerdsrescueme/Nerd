<?php

namespace CMS\Entity;

/**
 * @Entity
 * @Table(name="nerd_components")
 * 
 * @package NerdCMS
 * @category Entities
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
class Component
{
	use Traits\Identified;
	use Traits\Regioned;

	/**
	 * @Id
	 * @Column(type="integer", scale=8, nullable=false)
	 * @GeneratedValue
	 */
	protected $id;

	/**
	 * Overload trait default property
	 * 
	 * @ManyToOne(targetEntity="Page", inversedBy="components")
	 * @JoinColumn(name="page_id", referencedColumnName="id")
	 */
	protected $page;
}