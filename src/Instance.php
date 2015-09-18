<?php

namespace Rougin\SparkPlug;

use CI_Controller;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Instance Class
 *
 * Get the CodeIgniter's instance
 * 
 * @package SparkPlug
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Instance
{
    /**
     * Defines constants and load required classes
     *
     * @return void
     */
    public function __construct()
    {
        // Define the APPPATH, VENDOR, and BASEPATH paths
        if ( ! defined('VENDOR')) {
            define('VENDOR', realpath('vendor') . '/');
        }

        if ( ! defined('APPPATH')) {
            define('APPPATH',  realpath('application') . '/');
        }

        if ( ! defined('ENVIRONMENT')) {
            $environment = isset($_SERVER['CI_ENV'])
                ? $_SERVER['CI_ENV']
                : 'development';

            define('ENVIRONMENT', $environment);
        }

        if ( ! defined('VIEWPATH')) {
            define('VIEWPATH', APPPATH . '/views/');
        }

        if ( ! file_exists(APPPATH)) {
            $message = 'Oops! We can\'t find the "application" directory!';

            exit($message . PHP_EOL);
        }

        // Search for the directory and defined it as the BASEPATH
        $directory = new RecursiveDirectoryIterator(
            getcwd(),
            FilesystemIterator::SKIP_DOTS
        );

        $iterator = new RecursiveIteratorIterator(
            $directory,
            RecursiveIteratorIterator::SELF_FIRST
        );

        $slash = DIRECTORY_SEPARATOR;

        if ( ! defined('BASEPATH')) {
            foreach ($iterator as $path) {
                $core = 'core' . $slash . 'CodeIgniter.php';

                if (strpos($path->__toString(), $core) !== FALSE) {
                    $basepath = str_replace($core, '', $path->__toString());

                    define('BASEPATH', $basepath);

                    break;
                }
            }
        }

        if ( ! defined('BASEPATH')) {
            $message = 'Oops! We can\'t find the "system" directory!';

            exit($message . PHP_EOL);
        }

        // Load the Common and Base Controller class
        require BASEPATH . 'core/Common.php';

        if ( ! class_exists('CI_Controller')) {
            require BASEPATH . 'core/Controller.php';
        }

        /**
         * Load the framework constants
         */

        if ( ! defined('FILE_READ_MODE')) {
            $constants = APPPATH . 'config/' . ENVIRONMENT . '/constants.php';

            if (file_exists($constants)) {
                require $constants;
            } else {
                require APPPATH . 'config/constants.php';
            }
        }

        // Important charset-related stuff
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
        @ini_set('mbstring.internal_encoding', $charset);

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
        @ini_set('iconv.internal_encoding', $charset);

        if (is_php('5.6')) {
            ini_set('php.internal_encoding', $charset);
        }

        // Set global configurations
        $GLOBALS['CFG'] = & load_class('Config', 'core');
        $GLOBALS['UNI'] = & load_class('Utf8', 'core');
        $GLOBALS['SEC'] = & load_class('Security', 'core');

        // Load the CodeIgniter's core classes
        load_class('Loader', 'core');
        load_class('Router', 'core');
        load_class('Input', 'core');
        load_class('Lang', 'core');
    }

    /**
     * Gets an instance of CodeIgniter.
     * 
     * @return CodeIgniter
     */
    public function get()
    {
        require 'GetInstance.php';

        return new CI_Controller();
    }
}
