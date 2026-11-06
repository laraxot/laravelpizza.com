<?php

declare(strict_types=1);
/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

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

        return array_values(array_filter(array_map(
            static fn (mixed $scope): ?string => \is_scalar($scope) || $scope instanceof \Stringable ? (string) $scope : null,
            $scopes
        ), static fn (?string $scope): bool => $scope !== null));
    }
}
