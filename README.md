# PHP Helpers

[![Latest Stable Version](https://img.shields.io/packagist/v/veloxia/php-helpers.svg?style=flat-square)](https://packagist.org/packages/veloxia/php-helpers)
[![Total Downloads](https://img.shields.io/packagist/dt/veloxia/php-helpers.svg?style=flat-square)](https://packagist.org/packages/veloxia/php-helpers)

Some PHP helpers.

## Installation

```bash
composer require veloxia/php-helpers
```

## Usage

### Capture

With `capture()` you can more easily return the `[1]` group of a regular expression, or `[0]` if no parenthesis are set. The function sets up delimeters automatically.

``` php
$text = 'This costs $200,00 including shipping.';

$exp = '\$(200),00'; // instead of /\$(200),00/i

echo capture($exp, $text);  // returns 200
```

It's also possible to use `capture_list()`. In this case the first match in the list of expressions will be returned.

``` php
$text = 'This costs 200 EUR including shipping.';
$exps = [
  '(\d+) USD',
  '(\d+) GBP',
  '\$(\d+)',
  '(\d+)',
];
echo capture_list($exps, $text); // => 200
```

### Number range

`number_range` creates a numeric range on the fly. Example:

``` php
echo number_range(10.5, 13.9, 2, '%');
// 10,50 – 13,90 %
```
