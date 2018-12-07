<?php

namespace Rougin\SparkPlug;

/**
 * Instance
 *
 * A static helper for the SparkPlug::instance method.
 *
 * @package SparkPlug
 * @author  Rougin Gutib <rougingutib@gmail.com>
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
    public static function create($path = '', array $server = array(), array $globals = array())
    {
        $globals = empty($globals) ? $GLOBALS : $globals;

        $server = empty($server) ? $_SERVER : $server;

        $sparkplug = new SparkPlug($globals, $server, $path);

        return $sparkplug->getCodeIgniter();
    }
}
