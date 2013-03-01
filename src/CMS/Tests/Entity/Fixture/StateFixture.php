<?php

namespace CMS\Tests\Entity\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class StateFixture extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $nj = new \CMS\Entity\State;
        $nj->setCode('NJ');
        $nj->setName('New Jersey');

        $nc = new \CMS\Entity\State;
        $nc->setCode('NC');
        $nc->setName('North Carolina');

        $pa = new \CMS\Entity\State;
        $pa->setCode('PA');
        $pa->setName('Pennsylvania');

        $this->addReference('nj', $nj);
        $this->addReference('nc', $nc);
        $this->addReference('pa', $pa);

        $manager->persist($nj);
        $manager->persist($nc);
        $manager->persist($pa);
        $manager->flush();
    }
}