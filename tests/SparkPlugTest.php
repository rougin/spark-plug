<?php

namespace Rougin\SparkPlug\Test;

use Rougin\SparkPlug\SparkPlug;

use PHPUnit_Framework_TestCase;

class SparkPlugTest extends PHPUnit_Framework_TestCase
{
    /**
     * Checks if the CodeIgniter instance is successfully retrieved.
     * 
     * @return void
     */
    public function testCodeIgniterInstance()
    {
        $appPath = __DIR__ . '/TestApp';

        $sparkPlug = new SparkPlug($GLOBALS, $_SERVER, $appPath);
        $codeIgniter = $sparkPlug->getCodeIgniter();

        $this->assertInstanceOf('CI_Controller', $codeIgniter);
    }
}
