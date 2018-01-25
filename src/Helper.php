<?php
namespace TechOne\Alipay;

/**
 *
 */
class Helper
{
    public static function studly_case
    ($str, $ucfirst = true) {
        while (($pos = strpos($str, '_')) !== false) {
            $str = substr($str, 0, $pos) . ucfirst(substr($str, $pos + 1));
        }
        return $ucfirst ? ucfirst($str) : $str;
    }
}
