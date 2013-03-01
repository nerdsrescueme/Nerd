<?php

namespace CMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class PermissionRepository extends EntityRepository
{
    public function getGroup($group)
    {
        $group = $group.'.%';

        return $this->_em->createQuery('SELECT p FROM CMS\Entity\Permission p WHERE p.name LIKE :group')
                         ->setParameter('group', $group)
                         ->useQueryCache(true)
                         ->useResultCache(true)
                         ->getResult();
    }

    public function getSimilar($group)
    {
        $group = '%.'.$group;

        return $this->_em->createQuery('SELECT p FROM CMS\Entity\Permission p WHERE p.name LIKE :group')
                         ->setParameter('group', $group)
                         ->useQueryCache(true)
                         ->useResultCache(true)
                         ->getResult();
    }
}
