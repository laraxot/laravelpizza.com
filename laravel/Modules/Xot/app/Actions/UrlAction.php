<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Spatie\QueueableAction\QueueableAction;

/**
 * Undocumented class.
<<<<<<< .merge_file_G54irB
 *
 * @see docs/contracts/url-action.md
 *
=======
 * @see docs/contracts/url-action.md
>>>>>>> .merge_file_x4BZUh
 * @contract docs/contracts/url-action.md
 */
class UrlAction
{
    use QueueableAction;

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

    public function checkValidUrl(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    public function execute(): void {}
}
