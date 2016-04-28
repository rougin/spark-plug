<?php

namespace Rougin\SparkPlug;

use CI_Controller;
use FilesystemIterator;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

/**
 * Spark Plug
 *
 * Returns a CodeIgniter's instance.
 * 
 * @package SparkPlug
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SparkPlug
{
    /**
     * @var array
     */
    protected $globals = [];

    /**
     * @var array
     */
    protected $server = [];

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @param array  $globals
     * @param array  $server
     * @param string $path
     */
    public function __construct(array &$globals, array $server, $path = '')
    {
        $this->globals =& $globals;
        $this->server = $server;
        $this->path = $path;

        $this->setPaths();
        $this->setEnvironment();
        $this->loadConstants();
        $this->loadClasses();
        $this->setCharSet();
    }

    /**
     * Returns a CodeIgniter instance.
     * 
     * @return CodeIgniter
     */
    public function getCodeIgniter()
    {
        // Sets global configurations
        $this->globals['CFG'] =& load_class('Config', 'core');
        $this->globals['UNI'] =& load_class('Utf8', 'core');
        $this->globals['SEC'] =& load_class('Security', 'core');

        // Loads the CodeIgniter's core classes
        load_class('Loader', 'core');
        load_class('Router', 'core');
        load_class('Input', 'core');
        load_class('Lang', 'core');

        // Loads the get_instance.php for loading libraries
        require 'get_instance.php';

        return new CI_Controller;
    }

    /**
     * Loads the Common and the Base Controller class.
     * 
     * @return void
     */
    protected function loadClasses()
    {
        require BASEPATH . 'core/Common.php';

        if ( ! class_exists('CI_Controller')) {
            require BASEPATH . 'core/Controller.php';
        }
    }

    /**
     * Loads the framework constants.
     * 
     * @return void
     */
    protected function loadConstants()
    {
        if (defined('FILE_READ_MODE')) {
            return;
        }

        $envConstants = APPPATH . 'config/' . ENVIRONMENT . '/constants.php';
        $constants = APPPATH . 'config/constants.php';

        if (file_exists($envConstants)) {
            $constants = $envConstants;
        }

        require $constants;
    }

    /**
     * Sets up important charset-related stuff.
     *
     * @return void
     */
    protected function setCharSet()
    {
        $charset = strtoupper(config_item('charset'));

        ini_set('default_charset', $charset);

        if ( ! defined('MB_ENABLED')) {
            define('MB_ENABLED', extension_loaded('mbstring'));
        }

        // mbstring.internal_encoding is deprecated starting with PHP 5.6
        // and it's usage triggers E_DEPRECATED messages.
        if ( ! is_php('5.6') && ! ini_get('mbstring.internal_encoding')) {
            ini_set('mbstring.internal_encoding', $charset);
        }

        // This is required for mb_convert_encoding() to strip invalid
        // characters. That's utilized by CI_Utf8, but it's also done for
        // consistency with iconv.
        mb_substitute_character('none');

        // There's an ICONV_IMPL constant, but the PHP manual says that using
        // iconv's predefined constants is "strongly discouraged".
        if ( ! defined('ICONV_ENABLED')) {
            define('ICONV_ENABLED', extension_loaded('iconv'));
        }
    }

    /**
     * Sets up the current environment.
     *
     * @return void
     */
    protected function setEnvironment()
    {
        $environment = 'development';

        if (isset($this->server['CI_ENV'])) {
            $environment = $this->server['CI_ENV'];
        }

        if ( ! defined('ENVIRONMENT')) {
            define('ENVIRONMENT', $environment);
        }
    }

    /**
     * Sets up the APPPATH, VENDOR, and BASEPATH constants.
     * 
     * @return void
     */
    protected function setPaths()
    {
        $applicationPath = realpath('application');
        $vendorPath = realpath('vendor');

        if ($this->path) {
            $vendorPath = $this->path . '/vendor';
            $applicationPath = $this->path . '/application';
        }

        if ( ! defined('APPPATH')) {
            define('APPPATH', $applicationPath . '/');
        }

        if ( ! defined('VENDOR')) {
            define('VENDOR', $vendorPath . '/');
        }

        if ( ! defined('VIEWPATH')) {
            define('VIEWPATH', APPPATH . '/views/');
        }

        if (defined('BASEPATH')) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(getcwd())
        );

        foreach ($iterator as $file) {
            $core = 'core' . DIRECTORY_SEPARATOR . 'CodeIgniter.php';

            if (strpos($file->getPathname(), $core) !== FALSE) {
                $path = str_replace($core, '', $file->getPathname());

                define('BASEPATH', $path);

                break;
            }
        }
    }
}
