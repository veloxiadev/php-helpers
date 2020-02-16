# PHP Helpers

Some PHP helpers.


## Installation

```bash
composer require veloxia/php-helpers
```

## Usage

``` php
$text = 'This costs $200,00 including shipping.';
echo capture('\$(200),00', $text); // => 200
```
Gg.
