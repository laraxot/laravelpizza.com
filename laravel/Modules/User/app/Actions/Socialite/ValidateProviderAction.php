<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Modules\User\Exceptions\ProviderNotConfigured;
use Spatie\QueueableAction\QueueableAction;

class ValidateProviderAction
{
    use QueueableAction;

    public function __construct(
        private readonly ProviderNotConfigured $providerNotConfiguredException,
    ) {}

    /**
     * Execute the action.
     */
    public function execute(string $provider): void
    {
        $res = config()->has('services.'.$provider);
        if (! $res) {
            throw $this->providerNotConfiguredException->make($provider);
        }
    }
}
