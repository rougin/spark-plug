# Spark Plug

[![Latest Stable Version](https://poser.pugx.org/rougin/spark-plug/v/stable)](https://packagist.org/packages/rougin/spark-plug) [![Total Downloads](https://poser.pugx.org/rougin/spark-plug/downloads)](https://packagist.org/packages/rougin/spark-plug) [![Latest Unstable Version](https://poser.pugx.org/rougin/spark-plug/v/unstable)](https://packagist.org/packages/rougin/spark-plug) [![License](https://poser.pugx.org/rougin/spark-plug/license)](https://packagist.org/packages/rougin/spark-plug) [![endorse](https://api.coderwall.com/rougin/endorsecount.png)](https://coderwall.com/rougin)

Another way to access CodeIgniter's instance

# Installation

Install ```Spark Plug``` via [Composer](https://getcomposer.org):

```$ composer require rougin/spark-plug```

# Why

The purpose of this library is to provide an access to the CodeIgniter's instance that is based on this [link](codeinphp.github.io/post/codeigniter-tip-accessing-codeigniter-instance-outside/). I just made a package of this via [Composer](https://getcomposer.org/) for easy access. This may help you in developing libraries for CodeIgniter that does not go through ```index.php```, giving you more flexibility to your desired library or console application.

Right now, I used this package as a dependency for [Combustor](https://github.com/rougin/combustor) and [Refinery](https://github.com/rougin/refinery) packages.

# Getting Started

```php
require 'vendor/autoload.php';

use Rougin\SparkPlug\Instance;

$instance = new Instance();
$codeigniter = $instance->get();

// You can now use its instance
$codeigniter->load->model('foo');
```