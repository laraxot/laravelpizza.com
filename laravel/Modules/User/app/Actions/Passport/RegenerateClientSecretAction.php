<?php

declare(strict_types=1);

namespace Modules\User\Actions\Passport;

use Illuminate\Support\Str;
use Modules\User\Models\OauthClient;
use Spatie\QueueableAction\QueueableAction;

/**
 * RegenerateClientSecretAction: Rigenera il secret di un client OAuth2.
 */
class RegenerateClientSecretAction
{
    use QueueableAction;

    /**
     * Rigenera il secret di un client OAuth2.
     *
     * @param  OauthClient|string  $client  Il client di cui rigenerare il secret
     * @return string Il nuovo secret (in chiaro)
     */
    public function execute(OauthClient|string $client): string
    {
        if (is_string($client)) {
            $client = OauthClient::findOrFail($client);
        }

        $newSecret = Str::random(40);
        $client->secret = $newSecret;
        $client->save();

        return $newSecret;
    }
}
