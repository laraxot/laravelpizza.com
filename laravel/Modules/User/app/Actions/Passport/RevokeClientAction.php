<?php

declare(strict_types=1);

namespace Modules\User\Actions\Passport;

use Modules\User\Models\OauthClient;
use Modules\User\Models\OauthToken;
use Spatie\QueueableAction\QueueableAction;

/**
 * RevokeClientAction: Revoca un client OAuth2 e tutti i suoi token.
 *
 * Questa action revoca un client OAuth2 e tutti i token associati,
 * rendendoli immediatamente non validi.
 */
class RevokeClientAction
{
    use QueueableAction;

    public function __construct(
        private readonly OauthClient $oauthClientModel,
        private readonly OauthToken $oauthTokenModel,
    ) {}

    /**
     * Revoca un client OAuth2 e tutti i suoi token.
     *
     * @param  OauthClient|string  $client  Il client da revocare (istanza o ID)
     * @param  bool  $revokeTokens  Se true, revoca anche tutti i token associati
     * @return bool True se il client è stato revocato con successo
     */
    public function revokeClient(OauthClient|string $client): bool
    {
        return $this->execute($client, false);
    }

    /**
     * Revoca un client OAuth2 e tutti i suoi token associati.
     *
     * @param  OauthClient|string  $client  Il client da revocare (istanza o ID)
     * @return bool True se il client e i suoi token sono stati revocati con successo
     */
    public function revokeClientAndTokens(OauthClient|string $client): bool
    {
        return $this->execute($client, true);
    }

    /**
     * Revoca un client OAuth2 e opzionalmente i suoi token.
     *
     * @param  OauthClient|string  $client  Il client da revocare (istanza o ID)
     * @param  bool  $revokeTokens  Se true, revoca anche tutti i token associati
     * @return bool True se il client è stato revocato con successo
     */
    private function execute(OauthClient|string $client, bool $revokeTokens): bool
    {
        if (is_string($client)) {
            $client = $this->oauthClientModel->find($client);
        }

        if (! $client instanceof OauthClient) {
            return false;
        }

        // Revoca tutti i token associati se richiesto
        if ($revokeTokens) {
            $this->oauthTokenModel->where('client_id', $client->id)
                ->where('revoked', false)
                ->update(['revoked' => true]);
        }

        // Revoca il client
        $client->revoked = true;
        $client->save();

        return true;
    }
}
