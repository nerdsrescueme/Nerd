<?php

namespace CMS\Tests\Entity;

class CityEntityTest extends EntityTestCase
{
	public function setUp()
    {
        $this->loadSchemas([
        	'CMS\Entity\City',
        	'CMS\Entity\State',
        ]);

        $this->loadFixtures();
    }

    public function tearDown()
    {
        $this->dropDatabase();
        $this->dropEntityManager();
    }

    public function testGetWoodburyHeightsByZip()
    {
        $cities = $this->getRepository('City');
        $wh = $cities->findOneByZip('08097'); $wv = $cities->findOneByZip('08093');

die(var_dump($wh->calculateDistanceTo($wv)));

        $actual = $wh->getCity();
        $expected = 'Woodbury Heights';

        $this->assertSame($actual, $expected, 'Finding city by zip code returns unexpected result');
    }
}