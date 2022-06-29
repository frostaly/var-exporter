# VarExporter Component

<img src="https://avatars.githubusercontent.com/u/95505865" alt="" align="left" height="64" style="margin-right:1rem">

The VarExporter component provides a simple alternative to PHP's `var_export()`.

[![Source Code](https://img.shields.io/badge/source-frostaly/var--exporter-blue.svg)](https://github.com/frostaly/var-exporter)
[![CI Status](https://github.com/frostaly/var-exporter/workflows/Build/badge.svg)](https://github.com/frostaly/var-exporter/actions?query=workflow%3A%22Build%22)
[![Code Quality](https://scrutinizer-ci.com/g/frostaly/var-exporter/badges/quality-score.png)](https://scrutinizer-ci.com/g/frostaly/var-exporter/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/frostaly/var-exporter/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/frostaly/var-exporter/?branch=master)
[![Software License](https://img.shields.io/badge/license-GPL-008877.svg)](https://github.com/frostaly/var-exporter/blob/master/LICENSE)

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
echo Frostaly\VarExporter\VarExporter::export(['foo' => 'bar', 'baz' => [1.0, true, null]]);
```
```php
[
    'foo' => 'bar',
    'baz' => [
        1.0,
        true,
        null,
    ]
]
```

## Exporting Objects

VarExporter determines the most appropriate method to export your object using the registered encoders.

### StdClassEncoder

It exports stdClass as an array to object cast.

```php
(object) [
    'foo' => 'Hello'
    'bar' => 'World',
]
```

### SetStateEncoder

It uses the `__set_state()` method just like `var_export` would do:

```php
Namespace\CustomClass::__set_state([
    'foo' => 'Hello'
    'bar' => 'World',
])
```

### SerializeEncoder

It uses `__serialize()` and `__unserialize()` methods and the `Frostaly\VarExporter\Instantiator` class:

```php
Frostaly\VarExporter\Instantiator::unserialize(Namespace\CustomClass::class, [
    'foo' => 'Hello',
    'bar' => 'World',
]);
```

### ObjectEncoder

It can encode any custom object using either its constructor and named arguments or the `Frostaly\VarExporter\Instantiator` class:

```php
new Namespace\CustomClass(
    foo: 'Hello',
    bar: 'World',
)
```

```php
Frostaly\VarExporter\Instantiator::construct(Namespace\CustomClass::class, [
    'foo' => 'Hello',
    'bar' => 'World',
]);
```

## Contributing

Anyone can contribute to this repository. Please do so by posting issues when you've found something that is unexpected or sending a pull request for improvements.