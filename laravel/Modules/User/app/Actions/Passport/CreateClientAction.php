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
 */
class CreateClientAction
{
    use QueueableAction;

    public function __construct(
        private readonly Str $stringHelper,
    ) {}

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
    public function createPersonalAccessClient(string $name, string $redirect, ?UserContract $user = null): OauthClient
    {
        return $this->execute($name, $redirect, true, false, $user, null);
    }

    /**
     * Crea un nuovo client OAuth2 di tipo "password client".
     */
    public function createPasswordClient(string $name, string $redirect, ?string $provider = null): OauthClient
    {
        return $this->execute($name, $redirect, false, true, null, $provider);
    }

    /**
     * Crea un nuovo client OAuth2.
     *
     * @param  string  $name  Nome del client
     * @param  string  $redirect  URL di redirect dopo autenticazione
     * @param  bool  $personalAccess  Indica se è un personal access client
     * @param  bool  $password  Indica se è un password client
     * @param  UserContract|null  $user  Utente proprietario del client (opzionale)
     * @param  string|null  $provider  Provider di autenticazione (default: 'users')
     * @return OauthClient Il client creato
     */
    private function execute(
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

        // Genera ID e secret se non forniti
        $client->id = (string) $this->stringHelper->uuid();
        $client->secret = $this->stringHelper->random(40);

        $client->save();

        return $client;
    }
}
