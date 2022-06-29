# VarExporter Component

<img src="https://avatars.githubusercontent.com/u/95505865" alt="" align="left" height="64">

The VarExporter component provides a simple alternative to PHP's `var_export()`.

[![Source Code](https://img.shields.io/badge/source-frostaly/var--exporter-blue.svg)](https://github.com/frostaly/var-exporter)
[![CI Status](https://github.com/frostaly/var-exporter/workflows/Build/badge.svg)](https://github.com/frostaly/var-exporter/actions?query=workflow%3A%22Build%22)
[![Code Quality](https://scrutinizer-ci.com/g/frostaly/var-exporter/badges/quality-score.png)](https://scrutinizer-ci.com/g/frostaly/var-exporter/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/frostaly/var-exporter/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/frostaly/var-exporter/?branch=master)
[![Software License](https://img.shields.io/badge/license-GPL-brightgreen.svg)](https://github.com/frostaly/var-exporter/blob/master/LICENSE)

## Requirements
- This library requires PHP 8.1 or later.

## Installation

This library is installable via [composer](https://getcomposer.org/):

```
$ composer require frostaly/var-exporter
```

## Quickstart

The VarExporter works like `var_export()`. It takes any value and returns the PHP code representation for that value:

```php
echo \Frostaly\VarExporter\VarExporter::export(['foo' => 'bar', 'baz' => [true, 1.0, null]]);

```
```php
[
    'foo' => 'bar',
    'baz' => [
        true,
        1.0,
        null,
    ]
]
```
