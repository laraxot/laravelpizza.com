<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Spatie\QueueableAction\QueueableAction;

class GetProviderButtonsAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(): array
    {
        return [];
    }
}
