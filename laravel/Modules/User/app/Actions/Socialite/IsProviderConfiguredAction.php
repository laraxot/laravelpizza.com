<?php

declare(strict_types=1);
/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

namespace Modules\User\Actions\Socialite;

use Spatie\QueueableAction\QueueableAction;

class IsProviderConfiguredAction
{
    use QueueableAction;

    /**
     * Configurato = client_id, client_secret e redirect hanno un valore vero (la sola chiave `services.<provider>`
     * esiste sempre: vedi GetMissingProviderSettingsAction).
     */
    public function execute(string $provider): bool
    {
        return app(GetMissingProviderSettingsAction::class)->execute($provider) === [];
    }
}
