<?php

namespace App\Helpers;


class FormatHelper
{
    /**
     * Turn a string into a slug.
     *
     * @param string  $string
     *
     * @return array
     */

    public static function slugify(string $string): string
    {

        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));

    }

}