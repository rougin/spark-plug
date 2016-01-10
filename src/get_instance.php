<?php

if ( ! function_exists('get_instance')) {
    /**
     * Gets an instance of CodeIgniter.
     * 
     * @return CI_Controller
     */
    function &get_instance()
    {
        return \CI_Controller::get_instance();
    }
}
