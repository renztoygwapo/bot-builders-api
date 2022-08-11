<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * Format Slug to CamelCase.
     *
     * @param string $string
     * @param string $separator
     * @return CamelCase string
     */
    public static function slugToCamelCase(string $string, string $separator)
    {
        return str_replace($separator, '', ucwords($string, $separator));
    }
}
