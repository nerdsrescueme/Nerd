<?php

namespace CMS\Entity;

/**
 * City entity
 * 
 * @Entity(readOnly=true)
 * @Table(name="nerd_cities")
 * 
 * @package NerdCMS
 * @subpackage Entities
 */
class City
{
    /**
	 * @Id
	 * @Column(type="integer", scale=5, nullable=false)
     *
     * @var integer
	 */
	private $zip;

    /**
     * @Column(type="string", length=50, nullable=false)
     * 
     * @var string
     */
    private $city;

    /**
     * @ManyToOne(targetEntity="State", inversedBy="cities")
     * @JoinColumn(name="state", referencedColumnName="code")
     * 
     * @var State
     */
    private $state;

    /**
     * @Column(type="string", length=50, nullable=false)
     * 
     * @var string
     */
    private $county;

    /**
     * @Column(type="float", nullable=false)
     * 
     * @var float
     */
    private $latitude;

    /**
     * @Column(type="float", nullable=false)
     * 
     * @var float
     */
    private $longitude;

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
        return $this->zip;
    }

    /**
     * Set entity zip code
     * 
     * When set/getting a zip code with a leading 0, please quote the string.
     * This must be done in order to prevent PHP from interpreting the integer 
     * as an octal number (ie. 08093 should be "08093")
     * 
     * @param integer|string $zip Zip code
     * @return void
     */
    public function setZip($zip)
    {
        $this->zip = (int) $zip;
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
     * Set entity city name
     * 
     * @param string $city City
     * @return void
     */
    public function setCity($city)
    {
        $this->city = (string) $city;
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
     * Set entity state association
     * 
     * @param State $state Related state entity
     * @return void
     */
    public function setState($state)
    {
        if (!$state instanceof State) {
            throw new \InvalidArgumentException('Argument 1 must be an instance of CMS\Entity\State');
        }

        $this->state = $state;
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
     * Set entity county
     * 
     * @param string $county Entity county
     * @return void
     */
    public function setCounty($county)
    {
        $this->county = (string) $county;
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
     * Set entity latitude coordinate
     * 
     * @param float $latitude Entity latitude
     * @return void
     */
    public function setLatitude($latitude)
    {
        $this->latitude = (float) $latitude;
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
     * Set entity longitude coordinate
     * 
     * @param float $longitude Entity longitude
     * @return void
     */
    public function setLongitude($longitude)
    {
        $this->longitude = (float) $longitude;
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
}