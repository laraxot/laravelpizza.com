<?php

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Modules\User\Exceptions\ProviderNotConfigured;
use Spatie\QueueableAction\QueueableAction;

class ValidateProviderAction
{
    use QueueableAction;

    /**
     * @throws ProviderNotConfigured se mancano client_id, client_secret o redirect (o sono segnaposto)
     */
    public function execute(string $provider): void
    {
        $missing = app(GetMissingProviderSettingsAction::class)->execute($provider);
        if ($missing !== []) {
            throw ProviderNotConfigured::make($provider, $missing);
        }
    }
}
