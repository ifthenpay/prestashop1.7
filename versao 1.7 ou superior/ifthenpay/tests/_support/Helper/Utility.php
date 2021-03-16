<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Utility extends \Codeception\Module
{
    public static function getPrivateProtectedPropertie(Object $class, string $propertie)
    {
        $reflection = new \ReflectionClass($class);
        $property = $reflection->getProperty($propertie);
        $property->setAccessible(true);
        return $property->getValue($class);
    }
}
