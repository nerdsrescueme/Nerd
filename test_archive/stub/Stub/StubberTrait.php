<?php

namespace Stub;

trait StubberTrait
{
	public static function createStub(array $properties)
	{
		$reflection = new \ReflectionClass(get_called_class());
		$object = $reflection->newInstance();

		foreach ($properties as $property => $value)
		{
			$setter = 'set'.ucfirst($property);
			if ($reflection->hasMethod($setter)) {
				$object->{$setter}($value);
			} else {
				$object->{$property} = $value;
			}
		}

		return $object;
	}
}