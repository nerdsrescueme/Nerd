<?php

namespace Entity;

use Codeception\Util\Stub;

class CityCest
{
    const VALID_FLOAT = 12.345;

    protected $class = 'CMS\Entity\City';

    public function getZip(\CodeGuy $I)
    {
        $I->amTesting('City.getZip');
        $I->haveStub($city = Stub::makeEmptyExcept($this->class, 'getZip', ['zip' => 19134]));
        $I->executeTestedMethodOn($city);

        $I->expect('->getZip() to return an integer')
          ->seeResultEquals(19134)
          ->seeResultIs('int');

        $I->changeProperty($city, 'zip', 8093);
        $I->executeTestedMethodOn($city);

        $I->expect('->getZip() to return a string when integer could be mistaken for octal number')
          ->seeResultEquals('08093')
          ->seeResultIs('string');
    }

    public function setZip(\CodeGuy $I)
    {
        $I->amTesting('City.setZip');
        $I->haveStub($city = Stub::makeEmptyExcept($this->class, 'setZip'));
        $I->executeTestedMethodOn($city, 19134);

        $I->expect('->setZip() to set integer and return null')
          ->seePropertyEquals($city, 'zip', 19134)
          ->seeResultIs(null);
    }

    public function getCity(\CodeGuy $I)
    {
        $I->amTesting('City.getCity');
        $I->haveStub($city = Stub::makeEmptyExcept($this->class, 'getCity', ['city' => 'value']));
        $I->executeTestedMethodOn($city);

        $I->expect('->getCity() to return a string')
          ->seeResultEquals('value')
          ->seeResultIs('string');
    }

    public function setCity(\CodeGuy $I)
    {
        $I->amTesting('City.setCity');
        $I->haveStub($city = Stub::makeEmptyExcept($this->class, 'setCity'));
        $I->executeTestedMethodOn($city, 'value');

        $I->expect('->setCity() to set string and return null')
          ->seePropertyEquals($city, 'city', 'value')
          ->seeResultIs(null);
    }

    public function getState(\CodeGuy $I)
    {
        $I->amTesting('City.getState');
        $I->haveStub($state = Stub::makeEmpty('CMS\Entity\State'));
        $I->haveStub($city = Stub::makeEmptyExcept($this->class, 'getState', ['state' => $state]));
        $I->executeTestedMethodOn($city);

        $I->expect('->getState() to return state object')
          ->seePropertyEquals($city, 'state', $state)
          ->seeResultEquals('value')
          ->seeResultIs('object');
    }

    public function setState(\CodeGuy $I)
    {
        $I->amTesting('City.setState');
        $I->haveStub($state = Stub::makeEmpty('CMS\Entity\State'));
        $I->haveStub($city = Stub::makeEmptyExcept($this->class, 'setState'));
        $I->executeTestedMethodOn($city, $state);

        $I->expect("->setState() to set an object and return null")
          ->seePropertyEquals($city, 'state', $state)
          ->seeResultIs(null);
    }

    public function getCounty(\CodeGuy $I)
    {
        $I->amTesting('City.getCounty');
        $I->haveStub($city = Stub::makeEmptyExcept($this->class, 'getCounty', ['county' => 'value']));
        $I->executeTestedMethodOn($city);

        $I->expect('->getCounty() to return a string')
          ->seeResultEquals('value')
          ->seeResultIs('string');
    }

    public function setCounty(\CodeGuy $I)
    {
        $I->amTesting('City.setCounty');
        $I->haveStub($city = Stub::makeEmptyExcept($this->class, 'setCounty'));
        $I->executeTestedMethodOn($city, 'value');

        $I->expect('->setCounty() to set a string and return null')
          ->seePropertyEquals($city, 'county', 'value')
          ->seeResultIs(null);
    }

    public function getLatitude(\CodeGuy $I)
    {
        $I->amTesting('City.getLatitude');
        $I->haveStub($city = Stub::makeEmptyExcept($this->class, 'getLatitude', ['latitude' => self::VALID_FLOAT]));
        $I->executeTestedMethodOn($city);

        $I->expect('->getLatitude() to return float')
          ->seeResultEquals(self::VALID_FLOAT)
          ->seeResultIs('float');
    }

    public function getRadianLatitude(\CodeGuy $I)
    {
        $I->amTesting('City.getRadianLatitude');
        $I->haveStub($city = Stub::makeEmptyExcept($this->class, 'getRadianLatitude', ['latitude' => self::VALID_FLOAT]));
        $I->executeTestedMethodOn($city);

        $I->expect('->getRadianLatitude() to return the radian equivalent of latitude float')
          ->seeResultEquals(deg2rad(self::VALID_FLOAT))
          ->seeResultIs('float');
    }

    public function setLatitude(\CodeGuy $I)
    {
        $I->amTesting('City.setLatitude');
        $I->haveStub($city = Stub::makeEmptyExcept($this->class, 'setLatitude'));
        $I->executeTestedMethodOn($city, self::VALID_FLOAT);

        $I->expect('->setLatitude() to set float and return null')
          ->seePropertyEquals($city, 'latitude', self::VALID_FLOAT)
          ->seeResultIs(null);
    }

    public function getLongitude(\CodeGuy $I)
    {
        $I->amTesting('City.getLongitude');
        $I->haveStub($city = Stub::makeEmptyExcept($this->class, 'getLongitude', ['longitude' => self::VALID_FLOAT]));
        $I->executeTestedMethodOn($city);

        $I->expect('->getLongitude() to return a float')
          ->seeResultEquals(self::VALID_FLOAT)
          ->seeResultIs('float');
    }

    public function getRadianLongitude(\CodeGuy $I)
    {
        $I->amTesting('City.getRadianLongitude');
        $I->haveStub($city = Stub::makeEmptyExcept($this->class, 'getRadianLongitude', ['longitude' => self::VALID_FLOAT]));
        $I->executeTestedMethodOn($city);

        $I->expect('->getRadianLongitude() to return the radian equivalent of longitude float')
          ->seeResultEquals(deg2rad(self::VALID_FLOAT))
          ->seeResultIs('float');
    }

    public function setLongitude(\CodeGuy $I)
    {
        $I->amTesting('City.setLongitude');
        $I->haveStub($city = Stub::makeEmptyExcept($this->class, 'setLongitude'));
        $I->executeTestedMethodOn($city, self::VALID_FLOAT);

        $I->expect('->setLongitude() to set float and return null')
          ->seePropertyEquals($city, 'longitude', self::VALID_FLOAT)
          ->seeResultIs(null);
    }

    public function getCoordinates(\CodeGuy $I)
    {
        $expected = ['latitude' => self::VALID_FLOAT, 'longitude' => self::VALID_FLOAT + 1];

        $I->amTesting('City.getCoordinates');
        $I->haveStub($city = Stub::makeEmptyExcept($this->class, 'getCoordinates', $expected));
        $I->executeTestedMethodOn($city);

        /* Cannot currently test due to Array to string conversion errors...

        $I->expect('->getCoordinates() to return associative array with set values')
          ->seeResultEquals($expected)
          ->seeResultIs('array');

        $I->expect('->getCoordinates(false) to return [<latitude>, <longitude>]')
          ->seeResultEquals([self::VALID_FLOAT, self::VALID_FLOAT + 1])
          ->seeResultIs('array');
        */
    }

    public function stringConversion(\CodeGuy $I)
    {
        $I->amTesting('City.__toString');
        $I->haveStub($city = Stub::make($this->class, ['zip' => 11111]));
        $I->executeTestedMethodOn($city);

        $I->expect('->__toString() to return a string with format CMS\Entity\City[<zip>]')
          ->seeResultEquals('CMS\Entity\City[11111]')
          ->seeResultIs('string');
    }
}