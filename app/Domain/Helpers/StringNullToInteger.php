<?php

namespace App\Domain\Helpers;

class StringNullToInteger
{
    public static function make($value)
    {
        return $value ? (int) $value : null;
    }
}