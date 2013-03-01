<?php

namespace CMS\Entity;

/**
 * @Entity
 * @Table(name="nerd_snippets")
 */
class Snippet
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
	 * @ManyToOne(targetEntity="Page", inversedBy="snippets")
	 * @JoinColumn(name="page_id", referencedColumnName="id")
	 */
	private $page;
}