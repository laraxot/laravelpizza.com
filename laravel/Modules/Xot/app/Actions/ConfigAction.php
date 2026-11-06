<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

/**
 * Class ConfigAction.
 */
class ConfigAction
{
    private static ?self $instance = null;

    public function __construct() {}

    public static function getInstance(): self
    {
        if (! self::$instance instanceof self) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public static function make(): self
    {
        return static::getInstance();
    }
}
