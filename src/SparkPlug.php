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
    protected $constants = array();

    /**
     * @var array
     */
    protected $globals = array();

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @var array
     */
    protected $server = array();

    /**
     * @param array       $globals
     * @param array       $server
     * @param string|null $path
     */
    public function __construct(array &$globals, array $server, $path = null)
    {
        $this->globals =& $globals;

        $this->path = $path === null ? getcwd() : $path;

        $this->server  = $server;

        $this->constants['APPPATH'] = $this->path . '/application/';

        $this->constants['VENDOR'] = $this->path . '/vendor/';

        $this->constants['VIEWPATH'] = $this->path . '/application/views/';

        $this->constants['ENVIRONMENT'] = 'development';
    }

    /**
     * Returns the Codeigniter singleton.
     * NOTE: To be removed in v1.0.0. Use instance() instead.
     *
     * @return \CI_Controller
     */
    public function getCodeIgniter()
    {
        return $this->instance();
    }

    /**
     * Returns the Codeigniter singleton.
     *
     * @return \CI_Controller
     */
    public function instance()
    {
        $this->paths();

        $this->environment($this->constants['ENVIRONMENT']);

        $this->constants();

        $this->common();

        $this->config();

        require 'helpers.php';

        $instance = \CI_Controller::get_instance();

        empty($instance) && $instance = new \CI_Controller;

        return $instance;
    }

    /**
     * Sets the constant with a value.
     *
     * @param string $key
     * @param string $value
     */
    public function set($key, $value)
    {
        $this->constants[$key] = $value;

        return $this;
    }

    /**
     * Sets the base path.
     *
     * @return void
     */
    protected function basepath()
    {
        $directory = new \RecursiveDirectoryIterator(getcwd());

        $iterator = new \RecursiveIteratorIterator($directory);

        foreach ($iterator as $item) {
            $core = 'core' . DIRECTORY_SEPARATOR . 'CodeIgniter.php';

            $exists = strpos($item->getPathname(), $core) !== false;

            $path = str_replace($core, '', $item->getPathname());

            $exists && ! defined('BASEPATH') && define('BASEPATH', $path);
        }
    }

    /**
     * Sets up important charset-related stuff.
     *
     * @return void
     */
    protected function charset()
    {
        ini_set('default_charset', $charset = strtoupper(config_item('charset')));

        defined('MB_ENABLED') || define('MB_ENABLED', extension_loaded('mbstring'));

        $encoding = 'mbstring.internal_encoding';

        ! is_php('5.6') && ! ini_get($encoding) && ini_set($encoding, $charset);

        $this->iconv();
    }

    /**
     * Loads the Common and the Base Controller class.
     *
     * @return void
     */
    protected function common()
    {
        $exists = class_exists('CI_Controller');

        require BASEPATH . 'core/Common.php';

        $exists || require BASEPATH . 'core/Controller.php';

        $this->charset();
    }

    /**
     * Sets global configurations.
     *
     * @return void
     */
    protected function config()
    {
        $this->globals['CFG'] =& load_class('Config', 'core');

        $this->globals['UNI'] =& load_class('Utf8', 'core');

        $this->globals['SEC'] =& load_class('Security', 'core');

        $this->core();
    }

    /**
     * Loads the framework constants.
     *
     * @return void
     */
    protected function constants()
    {
        $config = APPPATH . 'config/';

        $constants = $config . ENVIRONMENT . '/constants.php';

        $filename = $config . 'constants.php';

        file_exists($constants) && $filename = $constants;

        defined('FILE_READ_MODE') || require $filename;
    }

    /**
     * Loads the CodeIgniter's core classes.
     *
     * @return void
     */
    protected function core()
    {
        load_class('Loader', 'core');

        load_class('Router', 'core');

        load_class('Input', 'core');

        load_class('Lang', 'core');
    }

    /**
     * Sets up the current environment.
     *
     * @return void
     */
    protected function environment($value = 'development')
    {
        isset($this->server['CI_ENV']) && $value = $this->server['CI_ENV'];

        defined('ENVIRONMENT') || define('ENVIRONMENT', $value);
    }

    /**
     * Sets the ICONV constants.
     *
     * @param  boolean $enabled
     * @return void
     */
    protected function iconv($enabled = false)
    {
        mb_substitute_character('none') && $enabled = defined('ICONV_ENABLED');

        $enabled || define('ICONV_ENABLED', extension_loaded('iconv'));
    }

    /**
     * Sets up the APPPATH, VENDOR, and BASEPATH constants.
     *
     * @return void
     */
    protected function paths()
    {
        $paths = array('APPPATH' => $this->constants['APPPATH']);

        $paths['VENDOR'] = $this->constants['VENDOR'];

        $paths['VIEWPATH'] = $this->constants['VIEWPATH'];

        foreach ((array) $paths as $key => $value) {
            $defined = defined($key);

            $defined || define($key, $value);
        }

        defined('BASEPATH') || $this->basepath();
    }
}
