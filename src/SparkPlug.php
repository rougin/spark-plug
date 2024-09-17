<?php

namespace Rougin\SparkPlug;

/**
 * @package Spark Plug
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class SparkPlug
{
    /**
     * @var array<string, string>
     */
    protected $consts = array();

    /**
     * @var array<string, string>
     */
    protected $globals = array();

    /**
     * @var array<string, string>
     */
    protected $server = array();

    /**
     * @param array<string, string> $globals
     * @param array<string, string> $server
     * @param string|null           $root
     */
    public function __construct(array $globals, array $server, $root = null)
    {
        $this->globals = & $globals;

        /** @var string */
        $root = $root ? $root : getcwd();

        $this->server = $server;

        $app = ((string) realpath($root)) . '/';

        if (is_dir($root . '/application'))
        {
            $app = $root . '/application/';
        }

        $this->consts['APPPATH'] = $app;

        $this->consts['ENVIRONMENT'] = 'development';

        $this->consts['VIEWPATH'] = $app . 'views/';

        $this->consts['VENDOR'] = $root . '/vendor/';
    }

    /**
     * @deprecated since ~0.6, use "instance" instead.
     *
     * Returns the Codeigniter singleton.
     *
     * @return \Rougin\SparkPlug\Controller
     */
    public function getCodeIgniter()
    {
        return $this->instance();
    }

    /**
     * Returns the Codeigniter singleton.
     *
     * @return \Rougin\SparkPlug\Controller
     */
    public function instance()
    {
        $this->setPaths();

        $this->environment($this->consts['ENVIRONMENT']);

        $this->constants();

        $this->common();

        $this->config();

        require 'helpers.php';

        /** @var \Rougin\SparkPlug\Controller|null */
        $instance = Controller::get_instance();

        if (empty($instance))
        {
            $instance = new Controller;
        }

        return $instance;
    }

    /**
     * Sets the constant with a value.
     *
     * @param string $key
     * @param string $value
     *
     * @return self
     */
    public function set($key, $value)
    {
        $this->consts[$key] = $value;

        $path = $this->consts[$key] . '/views/';

        if ($key === 'APPPATH')
        {
            $this->consts['VIEWPATH'] = $path;
        }

        return $this;
    }

    /**
     * Sets the base path.
     *
     * @return void
     */
    protected function basepath()
    {
        $path = (string) getcwd();

        $path = new \RecursiveDirectoryIterator($path);

        /** @var \SplFileInfo[] */
        $items = new \RecursiveIteratorIterator($path);

        $slash = DIRECTORY_SEPARATOR;

        foreach ($items as $item)
        {
            $core = 'core' . $slash . 'CodeIgniter.php';

            $path = $item->getPathname();

            $exists = strpos($path, $core) !== false;

            $path = str_replace($core, '', $path);

            if ($exists && ! defined('BASEPATH'))
            {
                define('BASEPATH', (string) $path);
            }
        }
    }

    /**
     * Sets up important charset-related stuff.
     *
     * @return void
     */
    protected function charset()
    {
        /** @var string */
        $charset = config_item('charset');

        $charset = strtoupper($charset);

        ini_set('default_charset', $charset);

        if (! defined('MB_ENABLED'))
        {
            define('MB_ENABLED', extension_loaded('mbstring'));
        }

        $encoding = 'mbstring.internal_encoding';

        if (! is_php('5.6') && ! ini_get($encoding))
        {
            ini_set($encoding, $charset);
        }

        $this->iconv();
    }

    /**
     * Loads the Common and the Base Controller class.
     *
     * @return void
     */
    protected function common()
    {
        require BASEPATH . 'core/Common.php';

        if (! class_exists('CI_Controller'))
        {
            require BASEPATH . 'core/Controller.php';
        }

        $this->charset();
    }

    /**
     * Sets global configurations.
     *
     * @return void
     */
    protected function config()
    {
        /** @var string */
        $config = load_class('Config', 'core');

        $this->globals['CFG'] = & $config;

        /** @var string */
        $utf8 = load_class('Utf8', 'core');

        $this->globals['UNI'] = & $utf8;

        /** @var string */
        $security = load_class('Security', 'core');

        $this->globals['SEC'] = & $security;

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

        $consts = $config . ENVIRONMENT . '/constants.php';

        $filename = $config . 'constants.php';

        if (file_exists($consts))
        {
            $filename = $consts;
        }

        if (! defined('FILE_READ_MODE'))
        {
            require $filename;
        }
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

        load_class('Output', 'core');
    }

    /**
     * Sets up the current environment.
     *
     * @param string $value
     *
     * @return void
     */
    protected function environment($value = 'development')
    {
        if (isset($this->server['CI_ENV']))
        {
            $value = $this->server['CI_ENV'];
        }

        if (! defined('ENVIRONMENT'))
        {
            define('ENVIRONMENT', $value);
        }
    }

    /**
     * Sets the ICONV constants.
     *
     * @param boolean $enabled
     *
     * @return void
     */
    protected function iconv($enabled = false)
    {
        if (mb_substitute_character('none') === true)
        {
            $enabled = defined('ICONV_ENABLED');
        }

        if (! $enabled)
        {
            define('ICONV_ENABLED', extension_loaded('iconv'));
        }
    }

    /**
     * Sets up the APPPATH, VENDOR, and BASEPATH constants.
     *
     * @return void
     */
    protected function setPaths()
    {
        $paths = array('APPPATH' => $this->consts['APPPATH']);

        $paths['VENDOR'] = $this->consts['VENDOR'];

        $paths['VIEWPATH'] = $this->consts['VIEWPATH'];

        foreach ($paths as $key => $value)
        {
            if (! defined($key))
            {
                define($key, $value);
            }
        }

        if (! defined('BASEPATH'))
        {
            $this->basepath();
        }
    }
}
