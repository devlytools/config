<?php

namespace Devly\Tests;

use Devly\Support\Config;
use PHPUnit\Framework\TestCase;
use function Devly\Support\config;

class HelpersTest extends TestCase
{
    public function testGetStaticInstanceOfConfig() {
        $config = config();
        $config2 = config();

        $this->assertInstanceOf(Config::class, $config);
        $this->assertSame($config, $config2);
    }
}
