<?php

namespace Rougin\SparkPlug;

/**
 * @package SparkPlug
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class SparkPlugTest extends Testcase
{
    /**
     * @var \Rougin\SparkPlug\Controller
     */
    protected $ci;

    /**
     * Sets up the Codeigniter instance.
     *
     * @return void
     */
    public function doSetUp()
    {
        $_SERVER['CI_ENV'] = 'production';

        $folder = __DIR__ . '/Application';

        $sparkplug = new SparkPlug($GLOBALS, $_SERVER, $folder);

        $sparkplug->set('APPPATH', $folder . '/');

        $sparkplug->set('VIEWPATH', $folder . '/views/');

        $this->ci = $sparkplug->instance();
    }

    /**
     * @return void
     */
    public function test_ci_instance_retrieved()
    {
        $expected = get_class($this->ci);

        $result = $this->ci;

        $this->assertInstanceOf($expected, $result);
    }

    /**
     * @return void
     */
    public function test_library_loaded()
    {
        $this->ci->load->library('email');

        $expected = get_class($this->ci->email);

        $result = $this->ci->email;

        $this->assertInstanceOf($expected, $result);
    }

    /**
     * @return void
     */
    public function test_helper_loaded()
    {
        $this->ci->load->helper('inflector');

        $this->assertTrue(function_exists('singular'));
    }

    /**
     * Checks the environment-based configurations.
     *
     * @return void
     */
    public function test_environment_constants()
    {
        $config = $this->ci->config;

        // The said item is "true" in config/production/config.php
        // while it was "false" in the default config/config.php
        $this->assertTrue($config->item('composer_autoload'));
    }
}
