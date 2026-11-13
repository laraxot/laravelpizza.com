<?php

declare(strict_types=1);
/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

namespace Modules\User\Actions\Socialite;

// use DutchCodingCompany\FilamentSocialite\FilamentSocialite;
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Modules\User\Events\SocialiteUserConnected;
use Modules\User\Models\SocialiteUser;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;

class LoginUserAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(SocialiteUser $socialiteUser): RedirectResponse
    {
        // Relazione gia' caricata (callback OAuth, test) o letta ora dal database.
        /** @var mixed $user */
        $user = $socialiteUser->relationLoaded('user')
            ? $socialiteUser->getRelation('user')
            : $socialiteUser->user()->first();

        if ($user === null) {
            throw new \InvalidArgumentException('Socialite user has no related user.');
        }

        if (! $user instanceof Authenticatable || ! $user instanceof UserContract) {
            throw new \LogicException('User instance must implement Authenticatable.');
        }

        // Un account eliminato dal titolare (Gdpr DeleteAccountAction, `deleted_at`) resta chiuso anche con Google:
        // l'informativa dice che l'account e' disattivato subito, come per il login con password (LoginWidget).
        // Letto dagli attributi grezzi: un modello appena creato non ha la colonna caricata e
        // Model::preventAccessingMissingAttributes() farebbe fallire getAttribute().
        $attributes = $user instanceof Model ? $user->getAttributes() : [];
        if (($attributes['deleted_at'] ?? null) !== null) {
            return app(RedirectToLoginAction::class)->execute('auth.user-not-allowed');
        }

        event(new SocialiteUserConnected($socialiteUser));

        Filament::auth()->login($user);

        return redirect()->intended('/');
    }
}
