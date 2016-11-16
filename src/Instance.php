<?php

namespace Rougin\SparkPlug;

/**
 * Instance
 *
 * Creates an instance based on SparkPlug class.
 *
 * @package SparkPlug
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Instance
{
    /**
     * Creates an instance of CodeIgniter based on the application path.
     *
     * @param  string $path
     * @param  array  $server
     * @param  array  $globals
     * @return \CI_Controller
     */
    public static function create($path = '', array $server = [], array $globals = [])
    {
        $globals = (empty($globals)) ? $GLOBALS : $globals;
        $server  = (empty($server)) ? $_SERVER : $server;

        return (new SparkPlug($globals, $server, $path))->getCodeIgniter();
    }
}
