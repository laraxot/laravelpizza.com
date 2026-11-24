<?php

declare(strict_types=1);
/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

namespace Modules\User\Actions\Socialite;

use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/is-provider-configured-action.md
 *
 * @contract docs/contracts/is-provider-configured-action.md
 */
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
