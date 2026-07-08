<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Illuminate\Support\Arr;
use Spatie\QueueableAction\QueueableAction;

class GetProviderScopesAction
{
    use QueueableAction;

    /**
     * Execute the action.
     *
     * @return array<int, string>
     */
    public function execute(string $provider): array
    {
        $services = config('services');
        if (! is_array($services)) {
            return [];
        }

        $scopes = Arr::get($services, $provider.'.scopes');
        if (! \is_array($scopes)) {
            return [];
        }

        return array_values(array_map(static fn (mixed $scope): string => (string) $scope, $scopes));
    }
}
