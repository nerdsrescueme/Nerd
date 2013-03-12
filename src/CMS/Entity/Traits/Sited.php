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