# Spark Plug

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Another way to access [CodeIgniter](https://codeigniter.com/)'s instance

## Install

Via Composer

``` bash
$ composer require rougin/spark-plug
```

## Usage

### Basic Usage

``` php
$sparkPlug = new Rougin\SparkPlug\SparkPlug($GLOBALS, $_SERVER);

$codeIgniter = $sparkPlug->getCodeIgniter();

// You can now use its instance
$codeIgniter->load->model('foo');
```

### As a mock instance for unit testing

``` php
class SparkPlugTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Checks if the CodeIgniter instance is successfully retrieved.
     * 
     * @return void
     */
    public function testCodeIgniterInstance()
    {
        // Path of your test application
        $appPath = __DIR__ . '/TestApp';

        $sparkPlug = new \Rougin\SparkPlug\SparkPlug($GLOBALS, $_SERVER, $appPath);
        $codeIgniter = $sparkPlug->getCodeIgniter();

        $this->assertInstanceOf('CI_Controller', $codeIgniter);
    }
}
```

**NOTE**: [rougin/codeigniter](https://github.com/rougin/codeigniter) and a test application directory are required to use it as a mock instance. Kindly check the [tests](https://github.com/rougin/spark-plug/tree/master/tests) directory for more information.

## Change Log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

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
