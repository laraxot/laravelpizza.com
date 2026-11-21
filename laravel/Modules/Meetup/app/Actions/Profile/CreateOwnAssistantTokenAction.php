<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Profile;

use Laravel\Passport\ClientRepository;
use Modules\User\Models\User;
use RuntimeException;

/**
 * Token personale per collegare un assistente AI (Claude, Cursor, ...) al server MCP (/api/mcp) a nome dell'utente.
 * Il token in chiaro si vede una volta sola: Passport salva solo il suo identificativo.
 * Se il client "personal access" di Passport non c'è ancora lo crea (una volta per ambiente, come da runbook).
 */
final class CreateOwnAssistantTokenAction
{
    public const CLIENT_NAME = 'Laravel Pizza MCP';

    public function __construct(private readonly ClientRepository $clients) {}

    /** @return array{id: string, name: string, token: string} */
    public function execute(User $user, string $name): array
    {
        $name = trim($name);
        if ($name === '') {
            throw new RuntimeException('Token name is required.');
        }

        $this->ensurePersonalAccessClient();
        $result = $user->createToken($name);
        $id = $result->accessTokenId;
        $token = $result->accessToken;
        if (! is_string($id) || ! is_string($token)) {
            throw new RuntimeException('Passport did not return the personal access token.');
        }

        return ['id' => $id, 'name' => $name, 'token' => $token];
    }

    private function ensurePersonalAccessClient(): void
    {
        $provider = config('auth.guards.api.provider');
        $provider = is_string($provider) && $provider !== '' ? $provider : 'users';

        try {
            $this->clients->personalAccessClient($provider);
        } catch (RuntimeException) {
            $this->clients->createPersonalAccessGrantClient(self::CLIENT_NAME, $provider);
        }
    }
}
