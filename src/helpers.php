<?php
namespace Devly\Support;

/**
 * Returns static instance of Config
 *
 * @return Config
 */
function config(): Config
{
    static $instance;

    if(null === $instance) {
        $instance = new Config();
    }

    return $instance;
}