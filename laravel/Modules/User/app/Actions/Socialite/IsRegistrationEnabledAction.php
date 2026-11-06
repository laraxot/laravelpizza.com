<?php

declare(strict_types=1);
/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

namespace Modules\User\Actions\Socialite;

use Spatie\QueueableAction\QueueableAction;

class IsRegistrationEnabledAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(): bool
    {
        return (bool) config('socialite.registration', true);
    }
}
