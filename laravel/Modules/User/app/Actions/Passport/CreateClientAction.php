<?php

declare(strict_types=1);

namespace Modules\User\Actions\Passport;

use Illuminate\Support\Str;
use Modules\User\Models\OauthClient;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;

/**
 * CreateClientAction: Crea un nuovo client OAuth2.
 *
 * Questa action crea un nuovo client OAuth2 con le configurazioni specificate.
 *
 * @see docs/contracts/create-client-action.md
 * @contract docs/contracts/create-client-action.md
 */
class CreateClientAction
{
    use QueueableAction;

    /**
     * Crea un nuovo client OAuth2.
     *
     * @param  string  $name  Nome del client
     * @param  string  $redirect  URL di redirect dopo autenticazione
     * @param  UserContract|null  $user  Utente proprietario del client (opzionale)
     * @param  bool  $personalAccess  Indica se è un personal access client
     * @param  bool  $password  Indica se è un password client
     * @param  string|null  $provider  Provider di autenticazione (default: 'users')
     * @return OauthClient Il client creato
     */
    public function execute(
        string $name,
        string $redirect,
        ?UserContract $user = null,
        bool $personalAccess = false,
        bool $password = false,
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

        // Genera ID e secret se non forniti
        $client->id = (string) Str::uuid();
        $client->secret = Str::random(40);

        $client->save();

        return $client;
    }
}
