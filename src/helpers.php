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
     * @param string $input
     * @return int
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
     * @param array $expressions    An array of expressions (without delimeters)
     * @param string $matchAgainst  String to match against, e.g. "subject"
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
