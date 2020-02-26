<?php

/*
 * Just some helper functions.
 * 
 * (c) 2020 Viktor Svensson <viktor@veloxia.se>
 * 
 * MIT License.
 */

if (!function_exists('strip_all_whitespace')) {
    /**
     * Removes all whitespace from a string.
     *
     * @param string $input
     * @return string
     */
    function strip_all_whitespace($input)
    {
        return (string) preg_replace('#[\n\s\r\t  ]#u', '', $input);
    }
}

if (!function_exists('strip_all_non_digits')) {
    /**
     * Removes everything except [0-9] from a string and returns an integer.
     *
     * @param   string  $input
     *
     * @return  int            
     */
    function strip_all_non_digits($input)
    {
        return intval(preg_replace('#[^\d]#', '', $input));
    }
}

if (!function_exists('get_user_ip')) {
    /**
     * Get the user's IP address even if you're using a proxy like Cloudflare.
     *
     * @return string|null
     */
    function get_user_ip()
    {
        // no $_SERVER variable available
        if ($_SERVER === null) {
            return null;
        }
        // cloudflare
        else if (isset($_SERVER['CF_CONNECTING_IP'])) {
            return $_SERVER['CF_CONNECTING_IP'];
        }
        // some proxies
        else if (isset($_SERVER['X_FORWARDED_FOR'])) {
            return $_SERVER['X_FORWARDED_FOR'];
        }
        // default
        else if (isset($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }
        // fallback
        else {
            return null;
        }
    }
}

if (!function_exists('capture')) {
    /**
     * Get first capture group of a regular expression. [0] is considered the first capture group unless [1] exists.
     *
     * @param string $expression    Expression (without delimeters)
     * @param string $matchAgainst  String to match against, e.g. "subject"
     * 
     * @return string|null
     */
    function capture(string $expression, $matchAgainst)
    {
        if (preg_match('#' . $expression . '#iu', $matchAgainst, $hit)) {
            return @$hit[1] ?: $hit[0];
        }
        return null;
    }
}

if (!function_exists('capture_list')) {
    /**
     * Get the first match from a list of regular expressions. If a capture group is used, the first one will be returned.
     *
     * @param array     $expressions        An array of expressions (without delimeters)
     * @param string    $matchAgainst       String to match against, e.g. "subject"
     * 
     * @return string|null
     */
    function capture_list(array $expressions, $matchAgainst)
    {
        foreach ($expressions as $expression) {
            if ($match = capture($expression, $matchAgainst)) {
                return $match;
            }
        }
        return null;
    }
}

if (!function_exists('normalize_integer')) {
    /**
     * Convert a "number" of any format to an integer. Example: (string) 1,000,000.32 => (int) 1000000
     *
     * @param mixed $number
     * 
     * @return int|null
     */
    function normalize_integer($number)
    {
        return \Veloxia\Helpers\Normalizer::normalizeInteger($number);
    }
}

if (!function_exists('pretty_date_swedish')) {


    /**
     * Turns YYYY-mm-dd into "1 januari 2020". Uses current timestamp if input is left blank.
     *
     * @param   string|int  $date    The date
     * @param   array       ?$order  The desired order (default d m y)
     *
     * @return  string      [return description]
     */
    function pretty_date_swedish($date = null, array $order = ['d', 'm', 'y']): string
    {

        $months = [
            1 => 'januari',
            2 => 'februari',
            3 => 'mars',
            4 => 'april',
            5 => 'maj',
            6 => 'juni',
            7 => 'juli',
            8 => 'augusti',
            9 => 'september',
            10 => 'oktober',
            11 => 'november',
            12 => 'december',
        ];

        $date = is_string($date) ? strtotime($date) : $date;

        $results = [
            'y' => date('Y', $date),
            'm' => $months[intval(date('m', $date))],
            'd' => intval(date('d', $date)),
        ];

        return "{$results[$order[0]]} {$results[$order[1]]} {$results[$order[2]]}";
    }
}

if (!function_exists('alt_get')) {

    /**
     * Get the value of an array or object key, or return a placeholder if it doesn't exist.
     *
     * @param   array   $array  Array or object.
     * @param   string  $key    The key to look for.
     * @param   string  $alt    The alternative to display if the key is undefined.
     *
     * @return  mixed|null
     */
    function alt_get(array $array, string $key, string $alt = '–')
    {
        if (is_object($array)) {
            $array = (array) $array;
        }
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }
        return @$array[$key] ?: '–';
    }
}

if (!function_exists('number_range')) {

    /**
     * Display a number range, e.g. 10,30 – 15,40 %.
     *
     * @param   int|float           $from      The smaller number
     * @param   int|float|null      $to        The bigger number
     * @param   int                 $decimals  Number of decimals to use
     * @param   string              $unit      Unit, e.g. % or $
     *
     * @return  string
     */
    function number_range($from, $to, $decimals = 0, $unit = '')
    {
        $from = floatval($from);
        $to = floatval($to);
        $range = '';
        if ($from > 0 && $to > $from) {
            $range = number_format($from, $decimals, ',', ' ') . ' – ' . number_format($to, $decimals, ',', ' ');
        } else if ($from > 0) {
            $range = number_format($from, $decimals, ',', ' ');
        } else {
            return '–';
        }
        return trim($range . ' ' . $unit);
    }
}

if (!function_exists('camel')) {

    /**
     * Converts a string into camelCase.
     *
     * @param   string  $string  
     *
     * @return  string
     */
    function camel($string)
    {
        return lcfirst(
            preg_replace_callback('/([^\_]+)_?/i', function ($match) {
                return ucfirst($match[1]);
            }, $string)
        );
    }
}
