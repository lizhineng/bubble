<?php

namespace Zhineng\Bubble\Support;

class Arr
{
    /**
     * Get array value with dot notation.
     *
     * @param  mixed  $array
     * @param  string|null  $key
     * @param  mixed|null  $default
     * @return mixed
     */
    public static function get(mixed $array, string $key = null, mixed $default = null): mixed
    {
        if (! is_array($array)) {
            return $default;
        }

        if (is_null($key)) {
            return $array;
        }

        if (! str_contains($key, '.')) {
            return $array[$key] ?? $default;
        }

        foreach (explode('.', $key) as $segment) {
            if (array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }

        return $array;
    }
}
