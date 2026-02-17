<?php

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Modules\User\Exceptions\ProviderNotConfigured;
use Spatie\QueueableAction\QueueableAction;

class ValidateProviderAction
{
    use QueueableAction;

    public function execute(string $provider): void
    {
        $hasConfig = config()->has('services.'.$provider);
        if (! $hasConfig) {
            $ex = new ProviderNotConfigured;
            throw $ex->make($provider);
        }
    }
}
