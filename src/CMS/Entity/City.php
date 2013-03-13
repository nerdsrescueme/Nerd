<?php

namespace CMS\Entity;

use Gedmo\Mapping\Annotation as Ext;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * City entity
 * 
 * @Entity(readOnly=true)
 * @Table(name="nerd_cities")
 * 
 * @package NerdCMS
 * @category Entities
 * @author Frank Bardon Jr. <frank@nerdsrescue.me>
 */
class City
{
    /**
	 * @Id
	 * @Column(type="integer", scale=5, nullable=false) 
     *
     * @var integer
	 */
	protected $zip;

    /**
     * @Column(type="string", length=50, nullable=false)
     * 
     * @var string
     */
    protected $city;

    /**
     * @ManyToOne(targetEntity="State", inversedBy="cities")
     * @JoinColumn(name="state", referencedColumnName="code")
     * 
     * @var State
     */
    protected $state;

    /**
     * @Column(type="string", length=50, nullable=false)
     * 
     * @var string
     */
    protected $county;

    /**
     * @Column(type="float", nullable=false)
     * 
     * @var float
     */
    protected $latitude;

    /**
     * @Column(type="float", nullable=false)
     * 
     * @var float
     */
    protected $longitude;

    /**
     * Returns entity zip code
     * 
     * Will return a string value if zip begins with "0". It does this so PHP
     * does not interpret it as an octal number.
     * 
     * @return integer|string
     */
    public function getZip()
    {
        $zip = (string) $this->zip;

        return isset($zip{5}) ? $this->zip : str_pad($this->zip, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Returns entity city name
     * 
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Returns entity state association
     * 
     * @return State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Returns entity county
     * 
     * @return string
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * Returns entity latitude coordinate
     * 
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Returns entity latitude coordinate in radians
     * 
     * @return float
     */
    public function getRadianLatitude()
    {
        return deg2rad($this->latitude);
    }

    /**
     * Returns entity longitude coordinate
     * 
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Returns entity longitude coordinate in radians
     * 
     * @return float
     */
    public function getRadianLongitude()
    {
        return deg2rad($this->longitude);
    }

    /**
     * Returns entity coordinates as an array
     * 
     * <code>
     *     [46.321104, -75.2234411] // Non-assoc
     *     [latitude => 46.321104, longitude => -75.2234411] // Assoc
     * </code>
     * 
     * @param boolean $assoc Return an associative array if true
     * @return array
     */
    public function getCoordinates($assoc = true)
    {
        return $assoc
            ? ['latitude' => $this->getLatitude(), 'longitude' => $this->getLongitude()]
            : [$this->getLatitude(), $this->getLongitude()];
    }

    /**
     * Return string equivalent of this object
     * 
     * @return string
     */
    public function __toString()
    {
        return __CLASS__.'['.$this->getZip().']';
    }
}