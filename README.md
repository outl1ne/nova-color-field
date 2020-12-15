# Nova Color Field

[![Latest Version on Packagist](https://img.shields.io/packagist/v/optimistdigital/nova-color-field.svg?style=flat-square)](https://packagist.org/packages/optimistdigital/nova-color-field)
[![Total Downloads](https://img.shields.io/packagist/dt/optimistdigital/nova-color-field.svg?style=flat-square)](https://packagist.org/packages/optimistdigital/nova-color-field)

This [Laravel Nova](https://nova.laravel.com/) package allows you to create and manage menus and menu items.

## Requirements

- `php: >=7.2`
- `laravel/nova: ^3.0`

## Features

A simple Nova Color field utilizing [vue-color](https://github.com/xiaokaike/vue-color).

Forked from [timothyasp/nova-color-field](https://github.com/timothyasp/nova-color-field) and brought up to date with improvements.

## Screenshots

![Details page](TODO)

![Index page](TODO)

## Installation

Install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require optimistdigital/nova-color-field
```

## Usage

Use it like you would a regular Nova Field:

```php
use OptimistDigital\NovaColorField\Color;

public function fields(Request $request) {
    Color::make('Color'),
}
```

Optionally use themes, see the selection [here](http://xiaokaike.github.io/vue-color/).

```php
use OptimistDigital\NovaColorField\Color;

public function fields(Request $request) {
    Color::make('Color')->photoshop(),
    Color::make('Color')->swatches(),
    // ...
}
```

You can use any one of: `chrome, compact, grayscale, material, photoshop, sketch, slider, swatches`.

Palette support for adding custom colors to the pickers is also available:

```php
Color::make('Color')
  ->compact()
  ->palette(['#beaf00', '#DEADAF', '#000']);
```

## Credits

- [Tarvo Reinpalu](https://github.com/tarpsvo)
- [Timothy Asp](https://github.com/timothyasp)
- [Don Gilbert](https://github.com/dongilbert)
- [marvinrabe](https://github.com/marvinrrabe)

## License

Nova Color Field is open-sourced software licensed under the [MIT license](LICENSE.md).
