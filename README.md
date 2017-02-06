# A Monolog extension for formatting log entries for Google Cloud Logging

[![Author](http://img.shields.io/badge/author-@superbalist-blue.svg?style=flat-square)](https://twitter.com/superbalist)
[![StyleCI](https://styleci.io/repos/55397447/shield?branch=master)](https://styleci.io/repos/55397447)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/superbalist/monolog-google-cloud-json-formatter.svg?style=flat-square)](https://packagist.org/packages/superbalist/monolog-google-cloud-json-formatter)
[![Total Downloads](https://img.shields.io/packagist/dt/superbalist/monolog-google-cloud-json-formatter.svg?style=flat-square)](https://packagist.org/packages/superbalist/monolog-google-cloud-json-formatter)
[![Build Status](https://travis-ci.org/Superbalist/monolog-google-cloud-json-formatter.svg)](https://travis-ci.org/Superbalist/monolog-google-cloud-json-formatter)

This library works in conjunction with https://github.com/GoogleCloudPlatform/fluent-plugin-google-cloud

fluent-plugin-google-cloud is an output plugin for fluentd which sends logs to the Google Cloud Logging API.


This formatter outputs logs entries in json which the fluent-plugin-google-cloud application understands.

## Installation

```bash
composer require superbalist/monolog-google-cloud-json-formatter
```

## Usage

```php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Superbalist\Monolog\Formatter;

// create a handler
$handler = new StreamHandler('path/to/your.log', Logger::WARNING);

// use custom formatter in handler
$handler->setFormatter(new GoogleCloudJsonFormatter());

// create a log channel
$log = new Logger('name');
$log->pushHandler($handler);

// add records to the log
$log->addWarning('Foo');
$log->addError('Bar');
```
