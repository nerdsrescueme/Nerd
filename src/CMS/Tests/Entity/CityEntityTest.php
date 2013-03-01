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

    public function testDatabaseHasFixturesInside()
    {
        $message = 'Unabled to find requisite records to complete tests';
        $result = $this->getRepository('City')->findOneByZip('08097');
        $this->assertIsObject($result, $message);
    }

    /**
     * @depends testDatabaseHasFixturesInside
     */
    public function testResultGetZipCodeCompensatesOctalValues()
    {
        $result = $this->getRepository('City')->findOneByZip('08093')->getZip();
        $this->assertIsString($result, '->getZip() does not compensate for octal number values by returning a string');
    }
}