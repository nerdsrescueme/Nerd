<?php

namespace CMS\Entity\Traits;

use CMS\Entity\Site;

trait Sited
{
	/**
     * @ORM\Column(name="site_id", type="integer", scale=2, nullable=false)
     */
    protected $siteId;

    /**
     * Returns associated site id
     * 
     * @return integer ID of the site to which this page is associated
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * Explicitly set site id association
     * 
     * @todo Remove validation check when scalar type hinting hits
     * 
     * @param integer $siteId ID of the site to associate
     * @throws InvalidArgumentException If $siteId is not an integer value
     * @return void
     */
    public function setSiteId($siteId)
    {
        if (!is_int($siteId)) {
            throw new \InvalidArgumentException('Invalid type: Site ID must be an integer ['.gettype($siteId).'] given');
        }

        $this->siteId = $siteId;
    }

    /**
     * Returns associated site object
     * 
     * @return Site Site entity object
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Site site entity association
     * 
     * @param Site $site Entity object of the site to associate
     * @return void
     */
    public function setSite(Site $site)
    {
    	$this->site = $site;
    }
}