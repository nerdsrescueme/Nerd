<?php

namespace CMS\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="nerd_countries")
 * 
 * @package NerdCMS
 * @category Entities
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
class Country
{
    /**
	 * @ORM\Id
	 * @ORM\Column(type="string", length=2, nullable=false)
	 */
	protected $short;

    /**
     * @ORM\Column(type="string", length=3, nullable=false)
     */
    protected $long;

    /**
     * @ORM\Column(type="integer", scale=3, nullable=false)
     */
    protected $numeric;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $name;

    /**
     * Return country short code
     *
     * @return string
     */
    public function getShort()
    {
        return $this->short;
    }

    /**
     * Return country long code
     *
     * @return string
     */
    public function getLong()
    {
        return $this->long;
    }

    /**
     * Return country numeric code
     *
     * @return integer
     */
    public function getNumeric()
    {
        return $this->numeric;
    }

    /**
     * Return country name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}