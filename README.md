# Spark Plug

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

A special package that returns an application based on [Codeigniter 3](https://codeigniter.com/) as a single variable. Might be useful when testing a `Codeigniter 3` project to frameworks such as [PHPUnit](https://phpunit.de/).

## Installation

Install `Spark Plug` through [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/spark-plug
```

## Basic Usage

### Using the `Instance` helper

``` php
$ci = Rougin\SparkPlug\Instance::create();

// You can now use the CI_Controller instance
$ci->load->helper('inflector');
```

> [!NOTE]
> Instead of `CI_Controller`, it returns `Rougin\SparkPlug\Controller` for type-hinting its helpers and libraries.

### Using the `SparkPlug` class

``` php
use Rougin\SparkPlug\SparkPlug;

$sparkplug = new SparkPlug($GLOBALS, $_SERVER);

$ci = $sparkplug->instance();

// The Inflector helper is now loaded ---
$ci->load->helper('inflector');
// --------------------------------------
```

### Modify constants to be defined

``` php
use Rougin\SparkPlug\SparkPlug;

$sparkplug = new SparkPlug($GLOBALS, $_SERVER);

// Set the value of the APPPATH constant ---
$sparkplug->set('APPPATH', '/path/to/app');
// -----------------------------------------

$ci = $sparkplug->instance();
```

Available constants that can be modified:

* `APPPATH`
* `VENDOR`
* `VIEWPATH`

> [!NOTE]
> If setting a new `APPPATH` value, the value of `VIEWPATH` will be set to `APPPATH/views`.

### Mock `CI_Controller` for unit testing

``` php
use Rougin\SparkPlug\Instance;

class SampleTest extends \PHPUnit_Framework_TestCase
{
    public function testCodeigniterInstance()
    {
        // Directory path to the test application
        $application = __DIR__ . '/TestApp';

        // Instance::create($path, $_SERVER, $GLOBALS)
        $ci = Instance::create($application);

        $this->assertInstanceOf('CI_Controller', $ci);
    }
}
```

## Changelog

Please see [CHANGELOG][link-changelog] for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Credits

- [All contributors][link-contributors]

## License

The MIT License (MIT). Please see [LICENSE][link-license] for more information.

[ico-build]: https://img.shields.io/github/actions/workflow/status/rougin/spark-plug/build.yml?style=flat-square
[ico-coverage]: https://img.shields.io/codecov/c/github/rougin/spark-plug?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/spark-plug.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/rougin/spark-plug.svg?style=flat-square

[link-build]: https://github.com/rougin/spark-plug/actions
[link-changelog]: https://github.com/rougin/spark-plug/blob/master/CHANGELOG.md
[link-contributors]: https://github.com/rougin/spark-plug/contributors
[link-coverage]: https://app.codecov.io/gh/rougin/spark-plug
[link-downloads]: https://packagist.org/packages/rougin/spark-plug
[link-license]: https://github.com/rougin/spark-plug/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/spark-plug