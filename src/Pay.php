<?php
namespace TechOne\Alipay;

use TechOne\Alipay\Helper;

/**
 *
 */
class Pay
{
    public static function init($handler, array $configs = [])
    {
        $class = false !== strpos($handler, '\\') ? $handler : '\\TechOne\\Alipay\\handler\\' . Helper::studly_case($handler, true);
        return new $class($configs);
    }
}
