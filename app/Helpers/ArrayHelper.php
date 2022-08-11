<?php

namespace App\Helpers;

class ArrayHelper
{
    /**
     * Determine if the array index exists and not null.
     *
     * @param array $data
     * @param string $index
     * @return bool
     */
    public static function isset(array $data, string $index)
    {
        return isset($data[$index]);
    }

    /**
     * Find the same value in an array.
     *
     * @param array $array
     * @param $mixed
     * @return matched value
     */
    public static function find(array $array, $value)
    {
        $found_index = array_search($value, $array, true);

        return $found_index === false ? null : $array[$found_index];
    }

    /**
     * Find the same value in an array.
     *
     * @param array $array
     * @param $mixed
     * @return matched value
     */
    public static function findByKey(array $array, $value, $key)
    {
        $found_index = array_search($value, array_column($array, $key));
        return $found_index === false ? null : $array[$found_index];
    }


}
