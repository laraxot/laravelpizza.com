<?php

declare(strict_types=1);
/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

namespace Modules\User\Actions\Socialite;

use Spatie\QueueableAction\QueueableAction;

class GetProviderButtonsAction
{
    use QueueableAction;

    /**
     * Execute the action.
     *
     * @return array<int, never>
     */
    public function execute(): array
    {
        return [];
    }
}
