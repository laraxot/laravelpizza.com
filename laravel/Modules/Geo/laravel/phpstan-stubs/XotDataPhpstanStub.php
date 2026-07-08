<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

class XotData
{
    private static $instance;

    public static function make()
    {
        return self::getInstance();
    }

    private static function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __get($name)
    {
        return null;
    }

    public function __set($name, $value)
    {
    }
}
