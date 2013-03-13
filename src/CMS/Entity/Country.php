<?php

namespace CMS\Entity;

/**
 * @Entity(readOnly=true)
 * @Table(name="nerd_countries")
 * 
 * @package NerdCMS
 * @category Entities
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
class Country
{
    /**
	 * @Id
	 * @Column(type="string", length=2, nullable=false)
	 */
	protected $short;

    /**
     * @Column(type="string", length=3, nullable=false)
     */
    protected $long;

    /**
     * @Column(type="integer", scale=3, nullable=false)
     */
    protected $numeric;

    /**
     * @Column(type="string", length=50, nullable=false)
     */
    protected $name;


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