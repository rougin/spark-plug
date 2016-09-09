<?php

namespace Rougin\SparkPlug\Test;

use Rougin\SparkPlug\Instance;
use Rougin\SparkPlug\SparkPlug;

use PHPUnit_Framework_TestCase;

class SparkPlugTest extends PHPUnit_Framework_TestCase
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
        $_SERVER['CI_ENV'] = 'production';

        $this->ci = Instance::create(__DIR__ . '/TestApp', $_SERVER);
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
