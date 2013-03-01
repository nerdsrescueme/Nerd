<?php

namespace CMS\Entity;

/**
 * @Entity(readOnly=true)
 * @Table(name="nerd_countries")
 */
class Country
{
    /**
	 * @Id
	 * @Column(type="string", length=2, nullable=false)
	 */
	private $short;

    /**
     * @Column(type="string", length=3, nullable=false)
     */
    private $long;

    /**
     * @Column(type="integer", scale=3, nullable=false)
     */
    private $numeric;

    /**
     * @Column(type="string", length=50, nullable=false)
     */
    private $name;


    public function getShort()
    {
        return $this->short;
    }

    public function getLong()
    {
        return $this->long;
    }

    public function getNumeric()
    {
        return $this->numeric;
    }

    public function getName()
    {
        return $this->name;
    }
}