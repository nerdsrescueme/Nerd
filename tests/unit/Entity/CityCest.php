<?php

namespace Entity;

use Codeception\Util\Stub;

class CityCest
{
    protected $class = 'CMS\Entity\City';

    public function getState(\CodeGuy $I)
    {
        $I->amTestingMethod("{$this->class}.getState");
        $I->haveFakeClass($city = Stub::makeEmptyExcept($this->class, 'getState', ['state' => 'value']));

        $I->expect('method to return value')
          ->executeTestedMethodOn($city)
          ->seeResultEquals('value');
    }


    public function setState(\CodeGuy $I)
    {
        $I->amTestingMethod("{$this->class}.setState");
        $I->haveFakeClass($state = Stub::makeEmpty('CMS\Entity\State'));
        $I->haveFakeClass($city = Stub::makeEmptyExcept($this->class, 'setState', ['state' => $state]));

        $I->expect("method to return null")
          ->executeTestedMethodOn($city, $state)
          ->seePropertyEquals($city, 'state', $state)
          ->seeResultIs(null);

        $I->expect('exception to be thrown for string argument')
          ->executeMethod($city, 'setState', $state)
          ->seeExceptionThrown('InvalidArgumentException', 'Argument 1 must be an instance of CMS\Entity\State');
    }
}