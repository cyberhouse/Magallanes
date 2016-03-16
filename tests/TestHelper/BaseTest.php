<?php
namespace MageTest\TestHelper;

/*
 * (c) 2011-2015 Andrés Montañez <andres@andresmontanez.com>
 * (c) 2016 by Cyberhouse GmbH <office@cyberhouse.at>
 *
 * This is free software; you can redistribute it and/or
 * modify it under the terms of the MIT License (MIT)
 *
 * For the full copyright and license information see
 * <https://opensource.org/licenses/MIT>
 */

abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns value of non-public property from given class
     *
     * @param string|object $object Object instance or class name
     * @param string $propertyName Class' or object's property name
     * @return mixed
     */
    final protected function getPropertyValue($object, $propertyName)
    {
        $configProperty = new \ReflectionProperty($object, $propertyName);
        $configProperty->setAccessible(true);

        return  $configProperty->getValue($object);
    }

    /**
     * Sets value to given property and given object
     *
     * @param object $object Object instance
     * @param string $propertyName Property name
     * @param mixed $value Value to set
     */
    final protected function setPropertyValue($object, $propertyName, $value)
    {
        $configProperty = new \ReflectionProperty($object, $propertyName);
        $configProperty->setAccessible(true);
        $configProperty->setValue($object, $value);
    }

    /**
     * Disable logging to log file and turn off colors
     *
     * @before
     */
    protected function setUpConsoleStatics()
    {
        $consoleReflection = new \ReflectionClass('Mage\Console');
        $logEnableProperty = $consoleReflection->getProperty('logEnabled');
        $logEnableProperty->setAccessible(true);
        $logEnableProperty->setValue(false);

        $configMock = $this->getMock('Mage\Config');
        $configMock->expects($this->any())
            ->method('getParameter')
            ->with('no-color')
            ->willReturn(true);

        $configProperty = $consoleReflection->getProperty('config');
        $configProperty->setAccessible(true);
        $configProperty->setValue($configMock);
    }

    /**
     * Tests getter of given object for given property name and example value
     *
     * @param object $object Object instance
     * @param string $propertyName Property name
     * @param mixed $propertyValue Value to set
     */
    final protected function doTestGetter($object, $propertyName, $propertyValue)
    {
        $this->setPropertyValue($object, $propertyName, $propertyValue);
        $getterName = $this->getGetterName($propertyName);

        $actual = $object->$getterName();

        $this->assertSame($propertyValue, $actual);
    }

    /**
     * Tests setter of given object for given property name and example value
     *
     * @param object $object Object instance
     * @param string $propertyName Property name
     * @param mixed $propertyValue Value to set
     */
    final protected function doTestSetter($object, $propertyName, $propertyValue)
    {
        $setterName = $this->getSetterName($propertyName);
        $object->$setterName($propertyValue);

        $actual = $this->getPropertyValue($object, $propertyName);
        $this->assertSame($propertyValue, $actual);
    }

    /**
     * Returns the conventional getter name for given property name
     *
     * @param string $propertyName Property name
     * @return string Getter method name
     */
    private function getGetterName($propertyName)
    {
        return 'get' . ucfirst($propertyName);
    }

    /**
     * Returns the conventional setter name for given property name
     *
     * @param string $propertyName Property name
     * @return string Getter method name
     */
    private function getSetterName($propertyName)
    {
        return 'set' . ucfirst($propertyName);
    }
}
