<?php

namespace App\Support;

class Currency
{
    public static function toman(int|float|string|null $amount): string
    {
        return self::format($amount).' تومان';
    }

    public static function format(int|float|string|null $amount): string
    {
        return number_format((float) ($amount ?? 0), 0, '.', '/');
    }
}
