<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use InvalidArgumentException;

class StringHelper
{
    public static function doesntContain(string $value, array | string $ivalids): void
    {
        if (! Str::doesntContain($value, $ivalids)) {
            throw new InvalidArgumentException("O " . $value . " não deve conter ");
        }
    }
}