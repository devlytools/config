<?php

namespace Devly\Tests;

use Devly\Support\ConfigLoader;
use PHPUnit\Framework\TestCase;

class ConfigLoaderTest extends TestCase
{
    public function testLoadConfigurationsFromPhpFile() {
        $config = new ConfigLoader();
        $output = $config->loadFromFile(__DIR__ . '/config/app.php');
        $this->assertIsArray($output);
        $this->assertEquals('Config Loader', $output['name']);
        $this->assertEquals('1.0.0', $output['version']);
    }

    public function testLoadConfigurationsFromJsonFile() {
        $config = new ConfigLoader();
        $output = $config->loadFromFile(__DIR__ . '/config/app.json');
        $this->assertEquals('Config Loader', $output['name']);
        $this->assertEquals('1.0.0', $output['version']);
    }

    public function testLoadOnlyPhpFilesFromDirectory() {
        $config = new ConfigLoader();
        $output = $config->loadFromFile(__DIR__ . '/config/*.php');
        $this->assertIsArray($output);
        $this->assertEquals('Config Loader', $output['name']);
        $this->assertEquals('MyService', $output['service']);
        $this->assertFalse(isset($output['foo']));
    }

    public function testLoadOnlyJsonFilesFromDirectory() {
        $config = new ConfigLoader();
        $output = $config->loadFromFile(__DIR__ . '/config/*.json');
        $this->assertIsArray($output);
        $this->assertEquals('bar', $output['foo']);
        $this->assertFalse(isset($output['service']));
    }

    public function testLoadConfigurationFilesFromDirectory() {
        $config = new ConfigLoader();
        $output = $config->loadFromFile(__DIR__ . '/config/*');
        $this->assertIsArray($output);
        $this->assertEquals('Config Loader', $output['name']);
        $this->assertEquals('MyService', $output['service']);
        $this->assertEquals('bar', $output['foo']);
    }
}
