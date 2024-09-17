<?php

namespace Rougin\SparkPlug;

/**
 * @package Spark Plug
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class InstanceTest extends SparkPlugTest
{
    /**
     * @return void
     */
    public function doSetUp()
    {
        $server = array('CI_ENV' => 'production');

        $folder = __DIR__ . '/Codeigniter';

        $instance = Instance::create($folder, $server);

        $this->ci = $instance;
    }
}
