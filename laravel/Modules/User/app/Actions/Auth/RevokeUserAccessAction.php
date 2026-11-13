<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

use Illuminate\Support\Str;
use Modules\User\Models\BaseUser;
use Modules\User\Models\OauthRefreshToken;
use Modules\User\Models\OauthToken;
use Spatie\QueueableAction\QueueableAction;

/**
 * Chiude ogni accesso gia' concesso a un utente (SEC-05): token Passport, refresh token e cookie "ricordami".
 *
 * Si chiama quando l'account viene cancellato dal titolare. Il provider di {@see BuildActiveUserProviderAction} blocca gia' l'utente
 * con `deleted_at` valorizzato; qui si revocano anche i token, cosi' restano inutilizzabili anche se `deleted_at` venisse azzerato
 * (ripristino da back office) e il registro dei token dice il vero. Le sessioni web aperte su altri dispositivi cadono alla richiesta
 * successiva, perche' il provider non trova piu' l'utente.
 */
final class RevokeUserAccessAction
{
    use QueueableAction;

    /**
     * @return int numero di token di accesso revocati
     */
    public function execute(BaseUser $user): int
    {
        $tokenIds = OauthToken::query()
            ->where('user_id', $user->getKey())
            ->where('revoked', false)
            ->pluck('id')
            ->all();

        // Refresh token di TUTTI i token dell'utente (anche quelli gia' revocati: un refresh token valido rigenera l'accesso),
        // con una sottoquery sulla stessa connessione invece dell'elenco di id letto prima.
        OauthRefreshToken::query()
            ->whereIn('access_token_id', OauthToken::query()->select('id')->where('user_id', $user->getKey()))
            ->where('revoked', false)
            ->update(['revoked' => true]);

        if ($tokenIds !== []) {
            OauthToken::query()
                ->whereIn('id', $tokenIds)
                ->update(['revoked' => true]);
        }

        // getRememberToken() casts a NULL column to '', never null. Come SessionGuard::cycleRememberToken (logout) si ruota il token
        // invece di azzerarlo: setRememberToken() accetta solo stringhe e il vecchio cookie "ricordami" smette di valere allo stesso modo.
        if ($user->getRememberToken() !== '') {
            $user->setRememberToken(Str::random(60));
            $user->save();
        }

        return \count($tokenIds);
    }
}
