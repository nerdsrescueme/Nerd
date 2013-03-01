<?php

namespace CMS\Tests\Entity\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CityFixture extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $wh = new \CMS\Entity\City;
        $wh->setZip('08097');
        $wh->setCity('Woodbury Heights');
        $wh->setCounty('Gloucester');
        $wh->setLatitude(39.814162);
        $wh->setLongitude(-75.152972);
        $wh->setState(
            $this->getReference('nj')
        );

        $wv = new \CMS\Entity\City;
        $wv->setZip('08093');
        $wv->setCity('Westville');
        $wv->setCounty('Gloucester');
        $wv->setLatitude(39.860494);
        $wv->setLongitude(-75.132278);
        $wv->setState(
            $this->getReference('nj')
        );

        $manager->persist($wh);
        $manager->persist($wv);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array('CMS\Tests\Entity\Fixture\StateFixture');
    }
}