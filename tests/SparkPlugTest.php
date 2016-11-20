<?php

namespace Rougin\SparkPlug;

class SparkPlugTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \CI_Controller
     */
    protected $ci;

    /**
     * Sets up the CodeIgniter instance.
     *
     * @return void
     */
    public function setUp()
    {
        $folder = __DIR__ . '/TestApp';
        $server = [ 'CI_ENV' => 'production' ];

        $this->ci = \Rougin\SparkPlug\Instance::create($folder, $server);
    }

    /**
     * Checks if the CodeIgniter instance is successfully retrieved.
     *
     * @return void
     */
    public function testCodeIgniterInstance()
    {
        $this->assertInstanceOf('CI_Controller', $this->ci);
    }

    /**
     * Checks if the loaded library can be retrieved.
     *
     * @return void
     */
    public function testLoadLibrary()
    {
        $this->ci->load->library('email');

        $this->assertInstanceOf('CI_Email', $this->ci->email);
    }

    /**
     * Checks if the loaded helper can be retrieved.
     *
     * @return void
     */
    public function testLoadHelper()
    {
        $this->ci->load->helper('inflector');

        $this->assertTrue(function_exists('singular'));
    }

    /**
     * Checks the environment-based configurations.
     *
     * @return void
     */
    public function testEnvironmentConstants()
    {
        // The said item is "true" in config/production/config.php while it was
        // "false" in the default config/config.php
        $this->assertTrue($this->ci->config->item('composer_autoload'));
    }
}
