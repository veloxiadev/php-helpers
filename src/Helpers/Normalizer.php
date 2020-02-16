<?php

namespace Veloxia\Helpers;

class Normalizer
{
    /**
     * Convert a "number" of any format to an integer. Example: (string) 1,000,000.32 => (int) 1000000
     *
     * @param mixed $number
     * 
     * @return int|null
     */
    public static function normalizeInteger($number)
    {
        // first trim
        $number = trim($number);

        // strip away everything but [0-9] + [,.] + [\s]
        $number = preg_replace(
            '/[^\d\.,\s]/',
            '',
            $number
        );

        // setup a default handler
        $defaultHandler = function ($integerPart, $decimalPart) {
            $integerPart = strip_all_non_digits($integerPart);
            $decimalPart = strip_all_non_digits($decimalPart) / pow(10, strlen($decimalPart));
            return round($integerPart + round($decimalPart));
        };

        // each format has its own pattern and handler, and the formats should be getting more and more general
        foreach ([
            // Anything that is already an integer
            '/^(\d+)$/' => true,
            // 100,00 || 10000,00 || 1.000.000,12
            '/^([\d\s\.]+),(\d{2})$/' => $defaultHandler,
            // 100.00 || 10000.00 || 1,000,000.12
            '/^([\d\s\,]+)\.(\d{2})$/' => $defaultHandler,
        ] as $exp => $handler) {
            // check if the pattern matches, in that case run the handler and return the results
            if (preg_match($exp, $number, $hit)) {
                if ($handler === true) {
                    $val = $hit[1];
                } else {
                    unset($hit[0]);
                    $val = call_user_func_array($handler, $hit);
                }
                return intval(round($val));
            }
        }
        return null;
    }
}
