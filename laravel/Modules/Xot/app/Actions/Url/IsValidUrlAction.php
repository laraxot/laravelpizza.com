<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Url;

use Spatie\QueueableAction\QueueableAction;

/**
 * Replaces Modules\Xot\Services\UrlService::checkValidUrl() (archived to .bak).
 * @see docs/contracts/is-valid-url-action.md
 * @contract docs/contracts/is-valid-url-action.md
 */
class IsValidUrlAction
{
    use QueueableAction;

    public function execute(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}
