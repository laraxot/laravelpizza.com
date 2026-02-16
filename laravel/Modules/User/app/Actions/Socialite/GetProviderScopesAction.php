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

    public function __construct(
        private readonly Arr $arrHelper,
    ) {}

    /**
     * Execute the action.
     */
    public function execute(string $provider): array
    {
        /**
         * @var array|\ArrayAccess
         */
        $services = config('services');
        $scopes = $this->arrHelper->get($services, $provider.'.scopes');
        if (! \is_array($scopes)) {
            return [];
        }

        return $scopes;
    }
}
