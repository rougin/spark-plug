<?php

if (! function_exists('get_instance')) {
    /**
     * Returns current Codeigniter instance object.
     * Also references to the CI_Controller method.
     *
     * @return CI_Controller
     */
    function &get_instance()
    {
        return CI_Controller::get_instance();
    }
}
