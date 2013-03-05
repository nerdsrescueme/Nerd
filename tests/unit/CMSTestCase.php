<?php

class CMSTestCase extends PHPUnit_Framework_TestCase
{
	public function doSetterAndGetterTests($object, array $values, $testForFluency = false)
	{
		$reflection = new \ReflectionObject($object);
		$setters = [];

		// Setter tests
		foreach ($values as $property => $value) {
			$setter = 'set'.ucfirst($property);
			if ($reflection->hasMethod($setter)) {
				$return = $object->{$setter}($value);
				$setters[$property] = $value;
				if ($testForFluency) {
					$this->assertSame($object, $return, "->{$setter}() is not implemented with a fluent interface");
				} else {
					$this->assertNull($return, "->{$setter}() returns a value ($return} when it should return void");
				}
				unset($values[$property]);
			}
		}

		// Getter tests
		foreach ($setters as $property => $value) {
			$getter = 'get'.ucfirst($property);
			if ($reflection->hasMethod($getter)) {
				$this->assertEquals($object->{$getter}(), $value, "->{$getter}() does not return supplied/set value");
			}
		}

		// Ensure all submitted values were tested...
		if (count($values) > 0) {
			$untested = implode(', ', array_keys($values));
			$this->fail("Setter or getter methods not supplied for the given input array keys: $untested");
		}
	}
}