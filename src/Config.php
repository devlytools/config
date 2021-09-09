<?php

namespace Devly\Support;

use ArrayAccess;

class Config implements ArrayAccess
{

    protected $config = [];

    /**
     * @var ConfigLoader
     */
    protected $loader;

    public function __construct(array $items = [])
    {
        $this->config = $items;
    }

    public function offsetExists($id)
    {
        return $this->has($id);
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->config);
    }

    public function offsetGet($id)
    {
        return $this->get($id);
    }

    public function get(string $id, $default = null)
    {
        return $this->config[$id] ?? $default;
    }

    public function offsetSet($id, $value)
    {
        return $this->set($id, $value);
    }

    public function set(string $id, $value): Config
    {
        $this->config[$id] = $value;

        return $this;
    }

    public function offsetUnset($id)
    {
        $this->delete($id);
    }

    public function delete(string $id): Config
    {
        unset($this->config[$id]);

        return $this;
    }

    public function loadFromFile($paths): Config
    {
        if(null === $this->loader) {
            $this->loader = new ConfigLoader();
        }

        $config = $this->loader->loadFromFile($paths);

        $this->config = array_replace_recursive($this->config, $config);

        return $this;
    }
}