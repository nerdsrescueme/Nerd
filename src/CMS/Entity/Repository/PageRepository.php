<?php

namespace CMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use CMS\Entity\Site;

class PageRepository extends EntityRepository
{
    protected $site;

    public function setSite(Site $site)
    {
        $this->site = $site;
    }

    public function getHome()
    {
        return $this->_uriQuery()
                    ->setParameter('uri', '@@HOME')
                    ->getSingleResult();
    }

    public function getOneInSite($pageId)
    {
        return $this->_em->createQuery('SELECT p FROM CMS\Entity\Page p WHERE p.siteId = :site_id AND p.id = :id')
                    ->setParameter('site_id', $this->site->getId())
                    ->setParameter('id', $pageId)
                    ->getSingleResult();
    }

    public function getOneByUri($uri)
    {
        return $this->_uriQuery()
                    ->setParameter('uri', $uri)
                    ->getSingleResult();
    }

    public function getError($code = 404)
    {
        return $this->_uriQuery()
                    ->setParameter('uri', '@@'.$code)
                    ->getSingleResult();
    }

    private function _uriQuery()
    {
        return $this->_em->createQuery('SELECT p FROM CMS\Entity\Page p WHERE p.uri = :uri AND p.siteId = :site_id')
                         ->setParameter('site_id', $this->site->getId());
    }
}
