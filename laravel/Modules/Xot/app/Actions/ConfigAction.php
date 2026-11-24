<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

/**
 * Class ConfigAction.
<<<<<<< .merge_file_HFKVae
 *
 * @see docs/contracts/config-action.md
 *
=======
 * @see docs/contracts/config-action.md
>>>>>>> .merge_file_9rOkKy
 * @contract docs/contracts/config-action.md
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
