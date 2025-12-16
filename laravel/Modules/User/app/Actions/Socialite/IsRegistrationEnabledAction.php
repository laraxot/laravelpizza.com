<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class IsRegistrationEnabledAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(): bool
    {
        Assert::boolean($res = config('filament-socialite.registration'));

        return $res;
    }
}
