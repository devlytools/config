<?php

namespace Devly\Tests;

use Devly\Support\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testInitializeWithValues() {
        $options = ['foo' => 'bar'];
        $config = new Config($options);
        $this->assertEquals($options['foo'], $config['foo']);
    }

    public function testSetAndGet() {
        $config = new Config();
        $config->set('foo', 'bar');
        $output = $config->get('foo');
        $this->assertEquals('bar', $output);
    }

    public function testSetAndGetAsArray() {
        $config = new Config();
        $config['foo'] = 'bar';
        $output = $config['foo'];
        $this->assertEquals('bar', $output);
    }

    public function testHas() {
        $config = new Config();
        $config['foo'] = 'bar';
        $this->assertTrue(isset($config['foo']));
        $this->assertTrue($config->has('foo'));
    }

    public function testGetUndefined() {
        $config = new Config();
        $output = $config->get('foo');
        $this->assertFalse($config->has('foo'));
        $this->assertNull($output);
    }

    public function testGetWithDefaultValue() {
        $config = new Config();
        $output = $config->get('foo', 'bar');
        $this->assertFalse($config->has('foo'));
        $this->assertEquals('bar', $output);
    }

    public function testLoadConfigurationsFromPhpFile() {
        $config = new Config();
        $output = $config->loadFromFile(__DIR__ . '/config/app.php');
        $this->assertTrue(isset($output['name']));
        $this->assertTrue(isset($output['version']));
    }

    public function testLoadConfigurationsFromJsonFile() {
        $config = new Config();
        $output = $config->loadFromFile(__DIR__ . '/config/app.json');
        $this->assertTrue(isset($output['name']));
        $this->assertTrue(isset($output['version']));
        $this->assertTrue(isset($output['foo']));
    }

    public function testLoadOnlyJsonFilesFromDirectory() {
        $config = new Config();
        $output = $config->loadFromFile(__DIR__ . '/config/*.json');
        $this->assertTrue(isset($output['foo']));
        $this->assertFalse(isset($output['service']));
    }

    public function testLoadOnlyPhpFilesFromDirectory() {
        $config = new Config();
        $output = $config->loadFromFile(__DIR__ . '/config/*.php');
        $this->assertFalse(isset($output['foo']));
        $this->assertTrue(isset($output['version']));
        $this->assertTrue(isset($output['service']));
    }

    public function testLoadConfigurationFilesFromDirectory() {
        $config = new Config();
        $output = $config->loadFromFile(__DIR__ . '/config/*');
        $this->assertTrue(isset($output['name']));
        $this->assertTrue(isset($output['service']));
        $this->assertTrue(isset($output['foo']));
    }

    public function testChainMethods() {
        $config = new Config();
        $config->loadFromFile(__DIR__ . '/config/*')
            ->set('database', 'My Database')
            ->set('mailer', 'My Mailer')
            ->delete('foo');

        $this->assertTrue(isset($config['name']));
        $this->assertEquals('My Database', $config['database']);
        $this->assertFalse(isset($config['foo']));
    }

}
