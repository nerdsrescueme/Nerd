<?php

namespace CMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class SessionRepository extends EntityRepository
{
    public function deleteOldRecords($days = 14)
    {
        $dql = "DELETE CMS\Entity\Session s WHERE s.updatedAt > DATE_SUB(CURRENT_TIMESTAMP(), $days, 'day')";

        return $this->_em->createQuery($dql)->execute();
    }
}
