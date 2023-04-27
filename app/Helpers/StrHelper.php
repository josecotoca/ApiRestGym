<?php
namespace App\Helpers;

class StrHelper
{
    public static function generateCode($prefix, $value, $numberChar)
    {
        return str_pad($value, $numberChar, "{$prefix}-", '0');
    }

}
