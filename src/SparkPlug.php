<?php

namespace Rougin\SparkPlug;

use CI_Controller;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Spark Plug Class
 *
 * Get the CodeIgniter's instance
 * 
 * @package SparkPlug
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SparkPlug
{
    protected $globals;
    protected $server;

    /**
     * @param array $globals
     * @param array $server
     */
    public function __construct(array $globals, array $server)
    {
        $this->globals = $globals;
        $this->server = $server;

        $this->setPaths();
        $this->loadConstants();
        $this->loadClasses();
        $this->setCharSet();
    }

    /**
     * Gets an instance of CodeIgniter.
     * 
     * @return CodeIgniter
     */
    public function getCodeIgniter()
    {
        // Sets global configurations
        $GLOBALS['CFG'] =& load_class('Config', 'core');
        $GLOBALS['UNI'] =& load_class('Utf8', 'core');
        $GLOBALS['SEC'] =& load_class('Security', 'core');

        // Loads the CodeIgniter's core classes
        load_class('Loader', 'core');
        load_class('Router', 'core');
        load_class('Input', 'core');
        load_class('Lang', 'core');

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

        return;
    }

    /**
     * Loads the framework constants
     * 
     * @return void
     */
    protected function loadConstants()
    {
        if (defined('FILE_READ_MODE')) {
            return;
        }

        $constants = APPPATH . 'config/' . ENVIRONMENT . '/constants.php';

        if (file_exists($constants)) {
            return require $constants;
        }

        return require APPPATH . 'config/constants.php';
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

        if ( ! extension_loaded('mbstring')) {
            define('MB_ENABLED', FALSE);
        }

        if ( ! defined('MB_ENABLED')) {
            define('MB_ENABLED', TRUE);
        }

        // mbstring.internal_encoding is deprecated starting with PHP 5.6
        // and it's usage triggers E_DEPRECATED messages.
        
        if ( ! ini_get('mbstring.internal_encoding')) {
            ini_set('mbstring.internal_encoding', $charset);
        }

        // This is required for mb_convert_encoding() to strip invalid
        // characters. That's utilized by CI_Utf8, but it's also done for
        // consistency with iconv.
        mb_substitute_character('none');

        if ( ! extension_loaded('iconv')) {
            define('ICONV_ENABLED', FALSE);
        }

        // There's an ICONV_IMPL constant, but the PHP manual says that using
        // iconv's predefined constants is "strongly discouraged".
        if ( ! defined('ICONV_ENABLED')) {
            define('ICONV_ENABLED', TRUE);
        }

        // iconv.internal_encoding is deprecated starting with PHP 5.6
        // and it's usage triggers E_DEPRECATED messages.
        if ( ! ini_get('iconv.internal_encoding')) {
            ini_set('iconv.internal_encoding', $charset);
        }

        if (is_php('5.6')) {
            ini_set('php.internal_encoding', $charset);
        }

        return;
    }

    /**
     * Sets up the APPPATH, VENDOR, and BASEPATH constants
     * 
     * @return void|string
     */
    protected function setPaths()
    {
        if ( ! defined('VENDOR')) {
            define('VENDOR', realpath('vendor') . '/');
        }

        if ( ! defined('APPPATH')) {
            define('APPPATH', realpath('application') . '/');
        }

        if ( ! defined('ENVIRONMENT')) {
            $environment = isset($this->server['CI_ENV'])
                ? $this->server['CI_ENV']
                : 'development';

            define('ENVIRONMENT', $environment);
        }

        if ( ! defined('VIEWPATH')) {
            define('VIEWPATH', APPPATH . '/views/');
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(getcwd())
        );

        foreach ($iterator as $file) {
            $core = 'core' . DIRECTORY_SEPARATOR . 'CodeIgniter.php';

            if (strpos($file->getPathname(), $core) !== FALSE) {
                if ( ! defined('BASEPATH')) {
                    define(
                        'BASEPATH',
                        str_replace($core, '', $file->getPathname())
                    );
                }

                break;
            }
        }

        return;
    }
}
