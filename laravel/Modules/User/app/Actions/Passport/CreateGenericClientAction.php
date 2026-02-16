<?php

declare(strict_types=1);

namespace Modules\User\Actions\Passport;

use Illuminate\Support\Str;
use Modules\User\Models\OauthClient;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;

class CreateGenericClientAction
{
    use QueueableAction;

    public function execute(
        string $name,
        string $redirect,
        bool $personalAccess,
        bool $password,
        ?UserContract $user = null,
        ?string $provider = null,
    ): OauthClient {
        $client = new OauthClient;
        $client->name = $name;
        $client->redirect = $redirect;
        $client->personal_access_client = $personalAccess;
        $client->password_client = $password;
        $client->provider = $provider ?? 'users';
        $client->revoked = false;

        if ($user !== null) {
            $client->user_id = $user->id;
        }

        // Generate client ID and secret
        $client->id = (string) Str::uuid();
        $client->secret = Str::random(40);

        $client->save();

        return $client;
    }
}
