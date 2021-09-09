<?php

namespace Devly\Support;

class ConfigLoader
{
    /**
     * @param string|array $paths
     */
    public function loadFromFile($paths): array
    {
        $paths = (array) $paths;
        $files = [];
        foreach ($paths as $path) {
            $files = array_merge(
                $files,
                glob($path ?: [])
            );
        }

        $config = array_map(function ($file) {
            $parts = explode('.', $file);
            $ext = array_pop($parts);
            $output = [];

            switch ($ext) {
                case 'php':
                    $output = $this->parsePhp($file);
                    break;
                case 'json':
                    $output = $this->parseJson($file);
                    break;
            }

            return $output;
        } , $files);

        return array_replace_recursive(...$config);
    }

    /**
     * @param $file
     * @return array|mixed
     */
    protected function parseJson($file) : array
    {
        $json = file_get_contents($file);
        $json = json_decode($json, true);
        if (json_last_error()) {
            return [];
        }
        return $json;
    }

    /**
     * @param $file
     * @return array
     */
    protected function parsePhp($file): array
    {
        $output = require $file;
        return is_array($output) ? $output : [];
    }
}