<?php

class EnvironmentTest extends CMSTestCase
{
    public function testPHPVersionMinimum()
    {
        $message = 'PHP version is not greater than 5.4.4 ('.PHP_VERSION.' found)';
        $this->assertTrue(version_compare(PHP_VERSION, '5.4.4', '>='), $message);
    }

    public function testPDOExtensionInstalled()
    {
        $message = 'PDO extension is not enabled on your system';
        $this->assertTrue(phpversion('pdo') !== false, $message);
    }

    public function testMysqlExtensionInstalled()
    {
        $message = 'MySQL extension is not enabled on your system';
        $this->assertTrue(phpversion('mysql') !== false, $message);
    }
}