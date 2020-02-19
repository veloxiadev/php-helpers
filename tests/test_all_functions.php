#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\Assert;

// normalize_integer() 
Assert::assertSame(
    normalize_integer('127.00'),
    127
);
echo ".";

Assert::assertSame(
    normalize_integer('1000031'),
    1000031
);
echo ".";

Assert::assertSame(
    normalize_integer('1000031.39'),
    1000031
);
echo ".";
Assert::assertSame(
    normalize_integer('1000031.69'),
    1000032
);
echo ".";

// capture()
Assert::assertSame(
    capture('(heej)', 'Hello heej ok'),
    'heej'
);
echo ".";
Assert::assertSame(
    capture('\$(127).00', 'This costs $127.00'),
    '127'
);
echo ".";

// capture_list()
Assert::assertSame(
    capture_list([
        'abc',
        '123',
        'Hello (heej) ok',
    ], 'Hello heej ok'),
    'heej'
);
echo ".";
Assert::assertSame(
    capture('\$(127).00', 'This costs $127.00'),
    '127'
);
echo ".";

// get_user_ip()
$_SERVER['REMOTE_ADDR'] = '1.2.3.4';
Assert::assertSame(
    get_user_ip(),
    '1.2.3.4'
);
echo ".";

// strip_all_non_digits()
Assert::assertSame(
    strip_all_non_digits('123161 12312 415151'),
    12316112312415151
);
echo ".";


// pretty_date_swedish()
Assert::assertSame(
    pretty_date_swedish('2020-02-19'),
    '19 februari 2020'
);
echo ".";

echo " - Success!\n";
