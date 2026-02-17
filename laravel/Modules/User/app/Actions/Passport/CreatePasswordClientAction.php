<?php

declare(strict_types=1);

namespace Modules\User\Actions\Passport;

use Modules\User\Models\OauthClient;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;

class CreatePasswordClientAction
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
            personalAccess: false,
            password: true,
            user: $user,
            provider: $provider,
        );
    }
}
