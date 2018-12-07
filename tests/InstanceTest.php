<?php

namespace Rougin\SparkPlug;

/**
 * Instance Test
 *
 * @package SparkPlug
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class InstanceTest extends SparkPlugTest
{
    /**
     * Sets up the Codeigniter instance.
     *
     * @return void
     */
    public function setUp()
    {
        $server = array('CI_ENV' => 'production');

        $folder = __DIR__ . '/Codeigniter';

        $instance = Instance::create($folder, $server);

        $this->codeigniter = $instance;
    }
}
