<?php

namespace CMS\Entity;

/**
 * City entity
 * 
 * The City entity is used for various CMS convenience classes as well as a
 * general lookup for geographic data including locale functions, distance
 * calculations and simple auto-complete for locale data.
 * 
 * @Entity(readOnly=true)
 * @Table(name="nerd_cities")
 * 
 * @package NerdCMS
 * @subpackage Entities
 */
class City
{
    const MAJOR_SEMIAX = 6378137;
    const MINOR_SEMIAX = 6356752.3141;

    const DISTANCE_METERS = 0;
    const DISTANCE_KILOMETERS = 1;
    const DISTANCE_MILES = 2;

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
        if (strlen((string) $this->zip) != 5) {
            return str_pad((string) $this->zip, 5, "0", STR_PAD_LEFT);
        }

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
    public function setState(State $state)
    {
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

    /**
     * Return geographic distance to a given entity
     * 
     * Calculates geographic distance between this city and another given city
     * entity using Vincenty's formulae.
     * 
     * @see http://en.wikipedia.org/wiki/Vincenty%27s_formulae
     * @see https://github.com/treffynnon/Geographic-Calculations-in-PHP/blob/master/geography.class.php
     * 
     * @param City $city City of which to find distance
     * @param integer $measure Measurement standard for result
     * @return float
     */
    public function calculateDistanceTo(City $city, $measure = self::DISTANCE_MILES)
    {
        $f     = (self::MAJOR_SEMIAX - self::MINOR_SEMIAX) / self::MAJOR_SEMIAX;
        $L     = $city->getRadianLongitude() - $this->getRadianLongitude();
        $U1    = atan((1 - $f) * tan($this->getRadianLatitude()));
        $U2    = atan((1 - $f) * tan($city->getRadianLatitude()));
        $sinU1 = sin($U1) and $sinU2 = sin($U2);
        $cosU1 = cos($U1) and $cosU2 = cos($U2);

        $lambda  = $L;
        $lambdaP = 2 * pi();
        $i = 20;

        while(abs($lambda - $lambdaP) > 1e-12 and --$i > 0) {
            $sinLambda = sin($lambda);
            $cosLambda = cos($lambda);
            $sinSigma  = sqrt(($cosU2 * $sinLambda) * ($cosU2 * $sinLambda) + ($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosLambda) * ($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosLambda));

            if ($sinSigma == 0) {
                return 0;
            }

            $cosSigma   = $sinU1 * $sinU2 + $cosU1 * $cosU2 * $cosLambda;
            $sigma      = atan2($sinSigma, $cosSigma);
            $sinAlpha   = $cosU1 * $cosU2 * $sinLambda / $sinSigma;
            $cosSqAlpha = 1 - $sinAlpha * $sinAlpha;
            $cos2SigmaM = $cosSigma - 2 * $sinU1 * $sinU2 / $cosSqAlpha;
            if(is_nan($cos2SigmaM)) {
                $cos2SigmaM = 0;
            }
            $c = $f / 16 * $cosSqAlpha * (4 + $f * (4 - 3 * $cosSqAlpha));
            $lambdaP = $lambda;
            $lambda = $L + (1 - $c) * $f * $sinAlpha * ($sigma + $c * $sinSigma * ($cos2SigmaM + $c * $cosSigma * (-1 + 2 * $cos2SigmaM * $cos2SigmaM)));
        }

        if($i == 0) {
            return false;  //formula failed to converge
        }

        $uSq = $cosSqAlpha * (self::MAJOR_SEMIAX * self::MAJOR_SEMIAX - self::MINOR_SEMIAX * self::MINOR_SEMIAX) / (self::MINOR_SEMIAX * self::MINOR_SEMIAX);
        $A   = 1 + $uSq / 16384 * (4096 + $uSq * (-768 + $uSq * (320 - 175 * $uSq)));
        $B   = $uSq / 1024 * (256 + $uSq * (-128 + $uSq * (74 - 47 * $uSq)));
        $deltaSigma = $B * $sinSigma * ($cos2SigmaM + $B / 4 * ($cosSigma * (-1 + 2 * $cos2SigmaM * $cos2SigmaM) - $B / 6 * $cos2SigmaM * (-3 + 4 * $sinSigma * $sinSigma) * (-3 + 4 * $cos2SigmaM * $cos2SigmaM)));
        $d = (float) (self::MINOR_SEMIAX * $A * ($sigma - $deltaSigma));

        switch ($measure) {
            case self::DISTANCE_MILES :
                return $d *  0.000621371192;
                break;
            case self::DISTANCE_KILOMETERS:
                return $d / 1000;
                break;
            default:
                return $d;
        }
    }
}