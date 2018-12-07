<?php

namespace Rougin\SparkPlug;

/**
 * Spark Plug Test
 *
 * @package SparkPlug
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class SparkPlugTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \CI_Controller
     */
    protected $codeigniter;

    /**
     * Sets up the Codeigniter instance.
     *
     * @return void
     */
    public function setUp()
    {
        $_SERVER['CI_ENV'] = 'production';

        $folder = __DIR__ . '/Application';

        $sparkplug = new SparkPlug($GLOBALS, $_SERVER, $folder);

        $sparkplug->set('APPPATH', $folder . '/');

        $sparkplug->set('VIEWPATH', $folder . '/views/');

        $this->codeigniter = $sparkplug->instance();
    }

    /**
     * Checks if the Codeigniter instance is successfully retrieved.
     *
     * @return void
     */
    public function testCodeigniterInstance()
    {
        $expected = get_class($this->codeigniter);

        $result = $this->codeigniter;

        $this->assertInstanceOf($expected, $result);
    }

    /**
     * Checks if the loaded library can be retrieved.
     *
     * @return void
     */
    public function testLoadLibrary()
    {
        $this->codeigniter->load->library('email');

        $expected = get_class($this->codeigniter->email);

        $result = $this->codeigniter->email;

        $this->assertInstanceOf($expected, $result);
    }

    /**
     * Checks if the loaded helper can be retrieved.
     *
     * @return void
     */
    public function testLoadHelper()
    {
        $this->codeigniter->load->helper('inflector');

        $this->assertTrue(function_exists('singular'));
    }

    /**
     * Checks the environment-based configurations.
     *
     * @return void
     */
    public function testEnvironmentConstants()
    {
        $config = $this->codeigniter->config;

        // The said item is "true" in config/production/config.php
        // while it was "false" in the default config/config.php
        $this->assertTrue($config->item('composer_autoload'));
    }
}
