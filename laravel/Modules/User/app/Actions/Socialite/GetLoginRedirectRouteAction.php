<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Spatie\QueueableAction\QueueableAction;

class GetLoginRedirectRouteAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(): string
    {
        // return config('filament-socialite.login_redirect_route') ?? 'filament.pages.dashboard';
        return 'filament.admin.pages.dashboard';
    }
}
