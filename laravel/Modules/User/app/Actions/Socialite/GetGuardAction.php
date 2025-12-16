<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class GetGuardAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(): StatefulGuard|Guard
    {
        Assert::string($guard = config('filament.auth.guard'));

        return auth()->guard($guard);
    }
}
