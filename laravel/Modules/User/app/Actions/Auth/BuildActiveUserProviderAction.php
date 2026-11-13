<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Actions\Model\ModelHasColumnAction;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;

/**
 * Provider Eloquent degli utenti che esclude gli account cancellati dal titolare (SEC-05).
 *
 * La cancellazione GDPR (`Modules\Gdpr\Actions\Account\DeleteAccountAction`) valorizza solo `deleted_at`: `BaseUser` non usa `SoftDeletes`
 * e non ha uno scope globale, perche' la purga differita e il back office devono continuare a vedere quegli utenti.
 * Il filtro va quindi nel provider, che e' l'unico punto attraversato da tutti i login e da tutte le sessioni:
 * - `retrieveByCredentials`: login web, Filament, Volt, `POST /api/user/login`, reset password;
 * - `retrieveById`: sessione gia' aperta (a ogni richiesta) e token Passport (`auth:api`, tramite `PassportUserProvider`);
 * - `retrieveByToken`: cookie "ricordami".
 *
 * Registrato in `UserServiceProvider` al posto del driver `eloquent`: vale per ogni tenant senza toccare i file `config/<tenant>/auth.php`.
 * Il filtro si applica solo ai modelli utente del progetto (`UserContract`, implementato da `BaseUser` che ha `deleted_at`):
 * un altro modello autenticabile potrebbe non avere la colonna. Il confine e' il contratto, non la classe base.
 */
final class BuildActiveUserProviderAction
{
    use QueueableAction;

    public function execute(Hasher $hasher, string $model): EloquentUserProvider
    {
        $provider = new EloquentUserProvider($hasher, $model);

        $provider->withQuery(static function (Builder $query): void {
            $user = $query->getModel();
            if ($user instanceof UserContract
                && app(ModelHasColumnAction::class)->execute($user, 'deleted_at')) {
                $query->whereNull($user->qualifyColumn('deleted_at'));
            }
        });

        return $provider;
    }
}
