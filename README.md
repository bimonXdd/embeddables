# Embeddables library

[![Latest Version](https://img.shields.io/packagist/v/gentle/embeddables.svg?style=flat-square)](https://packagist.org/packages/gentle/embeddables)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/gentlero/embeddables/master.svg?style=flat-square)](https://travis-ci.org/gentlero/embeddables)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/b/gentlero/embeddables.svg?style=flat-square)](https://scrutinizer-ci.com/b/gentlero/embeddables/?branch=master)
[![Code quality](https://img.shields.io/scrutinizer/b/gentlero/embeddables.svg?style=flat-square)](https://scrutinizer-ci.com/b/gentlero/embeddables/?branch=master)

Small collection of Value Objects to ease composition.

## Install

Via Composer

``` bash
$ composer require gentle/embeddables
```

## Usage

``` php
use Gentle\Embeddable\Date;
use Gentle\Embeddable\Time;

$date = new Date(
    new Date\Year(2016),
    new Date\Month(12),
    new Date\Day(25)
);
echo (string)$date; // 2016-12-25

$time = new Time(
    new Time\Hour(23),
    new Time\Minutes('04'),
    new Time\Seconds(14)
);

// changing timezone will return a new `Time` object
$time = $time->withTimeZone(new \DateTimeZone('Europe/Monaco'));
echo (string)$time; // 23:04:14
```

## Documentation

See the [docs](docs) directory for details.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

For any security related issues, please send an email at [alex@gentle.ro][maintainer-pgp] instead of using the issue tracker.

## License

Licensed under the MIT License - see the LICENSE file for details.

[maintainer-pgp]: https://keybase.io/vimishor/key.asc
