<?php

namespace Rougin\SparkPlug;

/**
 * Spark Plug
 *
 * Returns an instance of CodeIgniter.
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
     * @var string
     */
    protected $path = '';

    /**
     * @var array
     */
    protected $server = [];

    /**
     * @param array  $globals
     * @param array  $server
     * @param string $path
     */
    public function __construct(array &$globals, array $server, $path = '')
    {
        $this->globals =& $globals;
        $this->path    = (empty($path)) ? getcwd() : $path;
        $this->server  = $server;
    }

    /**
     * Returns an instance of CodeIgniter.
     *
     * @return \CI_Controller
     */
    public function getCodeIgniter()
    {
        $this->setPathConstants();
        $this->prepareEnvironment();
        $this->defineConstants();
        $this->loadCommonClasses();
        $this->setCharacterSets();
        $this->setConfigurations();
        $this->loadCoreClasses();

        // Loads the get_instance.php for loading libraries
        require 'get_instance.php';

        $ci = \CI_Controller::get_instance();

        return (empty($ci)) ? new \CI_Controller : $ci;
    }

    /**
     * Loads the Common and the Base Controller class.
     *
     * @return void
     */
    protected function loadCommonClasses()
    {
        require BASEPATH . 'core/Common.php';

        class_exists('CI_Controller') || require BASEPATH . 'core/Controller.php';
    }

    /**
     * Loads the framework constants.
     *
     * @return void
     */
    protected function defineConstants()
    {
        $constants   = APPPATH . 'config/constants.php';
        $environment = APPPATH . 'config/' . ENVIRONMENT . '/constants.php';
        $filename    = file_exists($environment) ? $environment : $constants;

        defined('FILE_READ_MODE') || require $filename;
    }

    /**
     * Loads the CodeIgniter's core classes.
     *
     * @return void
     */
    protected function loadCoreClasses()
    {
        load_class('Loader', 'core');
        load_class('Router', 'core');
        load_class('Input', 'core');
        load_class('Lang', 'core');
    }

    /**
     * Sets the base path.
     *
     * @return void
     */
    protected function setBasePath()
    {
        $directory = new \RecursiveDirectoryIterator(getcwd());
        $iterator  = new \RecursiveIteratorIterator($directory);

        foreach ($iterator as $item) {
            $core = 'core' . DIRECTORY_SEPARATOR . 'CodeIgniter.php';

            if (strpos($item->getPathname(), $core) !== false) {
                $path = str_replace($core, '', $item->getPathname());

                define('BASEPATH', $path);

                break;
            }
        }
    }

    /**
     * Sets up important charset-related stuff.
     *
     * @return void
     */
    protected function setCharacterSets()
    {
        $charset = strtoupper(config_item('charset'));

        ini_set('default_charset', $charset);

        defined('MB_ENABLED') || define('MB_ENABLED', extension_loaded('mbstring'));

        // mbstring.internal_encoding is deprecated starting with PHP 5.6
        // and it's usage triggers E_DEPRECATED messages.
        if (! is_php('5.6') && ! ini_get('mbstring.internal_encoding')) {
            ini_set('mbstring.internal_encoding', $charset);
        }

        $this->setIconv();
    }

    /**
     * Sets up the current environment.
     *
     * @return void
     */
    protected function prepareEnvironment()
    {
        $environment = 'development';

        if (isset($this->server['CI_ENV'])) {
            $environment = $this->server['CI_ENV'];
        }

        defined('ENVIRONMENT') || define('ENVIRONMENT', $environment);
    }

    /**
     * Sets global configurations.
     *
     * @return void
     */
    protected function setConfigurations()
    {
        $this->globals['CFG'] =& load_class('Config', 'core');
        $this->globals['UNI'] =& load_class('Utf8', 'core');
        $this->globals['SEC'] =& load_class('Security', 'core');
    }

    /**
     * Sets up ICONV.
     *
     * @return void
     */
    protected function setIconv()
    {
        // This is required for mb_convert_encoding() to strip invalid
        // characters. That's utilized by CI_Utf8, but it's also done for
        // consistency with iconv.
        mb_substitute_character('none');

        // There's an ICONV_IMPL constant, but the PHP manual says that using
        // iconv's predefined constants is "strongly discouraged".
        defined('ICONV_ENABLED') || define('ICONV_ENABLED', extension_loaded('iconv'));
    }

    /**
     * Sets up the APPPATH, VENDOR, and BASEPATH constants.
     *
     * @return void
     */
    protected function setPathConstants()
    {
        $paths = [
            'APPPATH'  => $this->path . '/application/',
            'VENDOR'   => $this->path . '/vendor/',
            'VIEWPATH' => $this->path . '/application/views/',
        ];

        foreach ($paths as $key => $value) {
            defined($key) || define($key, $value);
        }

        defined('BASEPATH') || $this->setBasePath();
    }
}
