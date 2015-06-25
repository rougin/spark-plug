# Spark Plug

Another way to access CodeIgniter's instance

# Installation

Install ```Spark Plug``` via [Composer](https://getcomposer.org):

```$ composer require rougin/spark-plug```

# Why

The purpose of this library is to provide an access to the CodeIgniter's instance that is based on this [link](codeinphp.github.io/post/codeigniter-tip-accessing-codeigniter-instance-outside/). I just created a [Composer](https://getcomposer.org/) package for easy access. This may help you in developing libraries for CodeIgniter that does not go through ```index.php```.

I used this package as a dependency for [Combustor](https://github.com/rougin/combustor) and [Refinery](https://github.com/rougin/refinery).

# Getting Started

```php
require 'vendor/autoload.php';

use Rougin\SparkPlug\Instance;

$instance = new Instance();
$codeigniter = $instance->get();
```