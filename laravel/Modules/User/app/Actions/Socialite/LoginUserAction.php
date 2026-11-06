<?php

declare(strict_types=1);
/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

namespace Modules\User\Actions\Socialite;

// use DutchCodingCompany\FilamentSocialite\FilamentSocialite;
use Filament\Facades\Filament;
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
        /** @var UserContract $user */
        $user = $socialiteUser->user()->firstOrFail();
        // Un account eliminato dal titolare (Gdpr DeleteAccountAction, `deleted_at`) resta chiuso anche con Google:
        // l'informativa dice che l'account e' disattivato subito, come per il login con password (LoginWidget).
        if ($user->getAttribute('deleted_at') !== null) {
            return app(RedirectToLoginAction::class)->execute('auth.user-not-allowed');
        }


        event(new SocialiteUserConnected($socialiteUser));

        Filament::auth()->login($user);

        return redirect()->intended('/');
    }
}
