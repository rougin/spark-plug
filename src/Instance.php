<?php

namespace Rougin\SparkPlug;

/**
 * @package Spark Plug
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Instance
{
    /**
     * Creates a Codeigniter instance based on the application path.
     *
     * @param string                $path
     * @param array<string, string> $server
     * @param array<string, string> $globals
     *
     * @return \Rougin\SparkPlug\Controller
     */
    public static function create($path = '', array $server = array(), array $globals = array())
    {
        $globals = empty($globals) ? $GLOBALS : $globals;

        $server = empty($server) ? $_SERVER : $server;

        $sparkplug = new SparkPlug($globals, $server, $path);

        return $sparkplug->getCodeIgniter();
    }
}
