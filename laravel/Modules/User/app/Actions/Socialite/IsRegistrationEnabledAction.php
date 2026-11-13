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
        // Chiave assente o valorizzata a null (es. env non impostata): vale il default, registrazione attiva.
        $registration = config('socialite.registration');

        return $registration === null ? true : (bool) $registration;
    }
}
