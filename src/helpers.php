<?php

use Rougin\SparkPlug\Controller;

if (! function_exists('get_instance'))
{
    /**
     * Returns current Codeigniter instance object.
     * Also references to the CI_Controller method.
     *
     * @return \Rougin\SparkPlug\Controller
     */
    function &get_instance()
    {
        /** @var \Rougin\SparkPlug\Controller */
        return Controller::get_instance();
    }
}
