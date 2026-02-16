<?php

declare(strict_types=1);

namespace Modules\User\Actions\Passport;

use Illuminate\Support\Str;
use Modules\User\Models\OauthClient;
use Modules\Xot\Contracts\UserContract;
use Modules\User\Actions\Passport\CreateGenericClientAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * CreateClientAction: Crea un nuovo client OAuth2.
 *
 * Questa action crea un nuovo client OAuth2 con le configurazioni specificate.
 * Invocazione: app(CreateClientAction::class)->execute(...)
 */
class CreatePersonalAccessClientAction
{
    use QueueableAction;

    public function execute(
        string $name,
        string $redirect,
        ?UserContract $user = null,
        ?string $provider = null,
    ): OauthClient {
        return app(CreateGenericClientAction::class)->execute(
            name: $name,
            redirect: $redirect,
            personalAccess: true,
            password: false,
            user: $user,
            provider: $provider,
        );
    }
}
