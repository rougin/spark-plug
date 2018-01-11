# Spark Plug

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Returns [Codeigniter](https://codeigniter.com/) applications as single variables. Might be useful for testing frameworks such as [PHPUnit](https://phpunit.de/).

## Install

Via Composer

``` bash
$ composer require rougin/spark-plug
```

## Usage

### Using the `Instance` helper

``` php
$ci = Rougin\SparkPlug\Instance::create();

// You can now use its instance
$ci->load->helper('inflector');
```

### Using the `SparkPlug` class

``` php
use Rougin\SparkPlug\SparkPlug;

$sparkplug = SparkPlug($GLOBALS, $_SERVER);

$ci = $sparkplug->instance();

// You can now use its instance
$ci->load->helper('inflector');
```

### Modify constants to be defined

``` php
use Rougin\SparkPlug\SparkPlug;

$sparkplug = SparkPlug($GLOBALS, $_SERVER);

$sparkplug->set('APPPATH', '/path/to/app');
$sparkplug->set('VIEWPATH', '/path/to/app/views');

// \CI_Controller
$ci = $sparkplug->instance();
```

Available constants to be modified:

* `APPPATH`
* `VENDOR`
* `VIEWPATH`

NOTE: If set a new `APPPATH` value, it will automatically set its `VIEWPATH` to "`APPPATH`/views".

### Mock `CI_Controller` for unit testing

``` php
use Rougin\SparkPlug\Instance;

class SampleTest extends \PHPUnit_Framework_TestCase
{
    public function testCodeigniterInstance()
    {
        // Path of your test application
        $application = __DIR__ . '/TestApp';

        // Instance::create($path, $_SERVER, $GLOBALS)
        $ci = Instance::create($application);

        $this->assertInstanceOf('CI_Controller', $ci);
    }
}
```

**NOTE**: To create a mock instance, a [rougin/codeigniter](https://github.com/rougin/codeigniter) package and a test application directory are required. Kindly check the [tests](https://github.com/rougin/spark-plug/tree/master/tests) directory for more examples.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email rougingutib@gmail.com instead of using the issue tracker.

## Credits

- [Rougin Royce Gutib][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/rougin/spark-plug.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rougin/spark-plug/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/rougin/spark-plug.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/rougin/spark-plug.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/spark-plug.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/rougin/spark-plug
[link-travis]: https://travis-ci.org/rougin/spark-plug
[link-scrutinizer]: https://scrutinizer-ci.com/g/rougin/spark-plug/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/rougin/spark-plug
[link-downloads]: https://packagist.org/packages/rougin/spark-plug
[link-author]: https://github.com/rougin
[link-contributors]: ../../contributors