<?php

namespace CMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function authenticate($email, $password)
    {
        $dql = 'SELECT u FROM CMS\Entity\User u WHERE u.email = :email AND u.password = :password';

        return $this->_em->createQuery($dql)
                         ->setParameter('email', $email)
                         ->setParameter('password', $password)
                         ->getOneOrNullResult();
    }

    public function getSuperUsers()
    {
        return $this->_em->createQuery('SELECT u FROM CMS\Entity\User u WHERE u.super = 1')
                         ->useQueryCache(true)
                         ->getResult();
    }

    public function getBannedUsers()
    {
        return $this->_em->createQuery('SELECT u FROM CMS\Entity\User u WHERE u.status = \'banned\'')
                         ->useQueryCache(true)
                         ->getResult();
    }

    public function getInactiveUsers()
    {
        return $this->_em->createQuery('SELECT u FROM CMS\Entity\User u WHERE u.activated = 0')
                         ->useQueryCache(true)
                         ->getResult();
    }
}
