<?php

use Stub\Entity\CityResponder;
use Stub\Entity\CitySaboteur;
use CMS\Entity\City;

class Entity_CityTest extends CMSTestCase
{
    public function testSettersAndGetters()
    {
        $object = new City;
        $this->doSetterAndGetterTests($object, [
            'zip' => 19134,
            'city' => 'Philadelphia',
            'state' => $this->getMock('CMS\Entity\State'),
            'county' => 'Philadelphia',
            'latitude' => 12.3456,
            'longitude' => -65.4321,
        ]);
    }

    public function testGetCoordinatesDefaultValue()
    {
        $expected = ['latitude' => 12.3456, 'longitude' => -65.4321];
        $stub = CityResponder::createStub([
            'latitude' => $expected['latitude'],
            'longitude' => $expected['longitude'],
        ]);

        $this->assertEquals($stub->getCoordinates(), $expected, '->getCoordinates() does not return a proper associative array by default');
    }

    public function testGetCoordinatesNonAssociative()
    {
        $expected = [12.3456, -65.4321];
        $stub = CityResponder::createStub([
            'latitude' => $expected[0],
            'longitude' => $expected[1],
        ]);

        $this->assertEquals($stub->getCoordinates(false), $expected, '->getCoordinates(false) does not return the correct array value');
    }

    public function testGetRadianLatitude()
    {
        $expected = deg2rad(12.3456);
        $stub = CityResponder::createStub(['latitude' => 12.3456]);

        $this->assertEquals($stub->getRadianLatitude(), $expected, '->getRadianLatitude() does not return the proper degree to radian calculation');
    }

    public function testGetRadianLongitude()
    {
        $expected = deg2rad(12.3456);
        $stub = CityResponder::createStub(['longitude' => 12.3456]);

        $this->assertEquals($stub->getRadianLongitude(), $expected, '->getRadianLongitude() does not return the proper degree to radian calculation');
    }
}