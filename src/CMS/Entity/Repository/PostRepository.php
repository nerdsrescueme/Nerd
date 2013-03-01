<?php

namespace CMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use CMS\Entity\Site;

class PostRepository extends EntityRepository
{
    protected $site;

    public function setSite(Site $site)
    {
        $this->site = $site;
    }

    public function getAllInSite()
    {
        return $this->_em->createQuery('SELECT p FROM CMS\Entity\Post p WHERE p.siteId = :site_id')
                    ->setParameter('site_id', $this->site->getId())
                    ->getResult();
    }

    public function getOneInSite($postId)
    {
        return $this->_em->createQuery('SELECT p FROM CMS\Entity\Post p WHERE p.siteId = :site_id AND p.id = :id')
                    ->setParameter('site_id', $this->site->getId())
                    ->setParameter('id', $postId)
                    ->getSingleResult();
    }
}
