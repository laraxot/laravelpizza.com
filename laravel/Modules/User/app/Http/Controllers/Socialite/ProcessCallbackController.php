<?php

declare(strict_types=1);

/**
 * @see DutchCodingCompany\FilamentSocialite.
 */

namespace Modules\User\Http\Controllers\Socialite;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Modules\User\Actions\Socialite\IsRegistrationEnabledAction;
use Modules\User\Actions\Socialite\IsUserAllowedAction;
use Modules\User\Actions\Socialite\LoginUserAction;
use Modules\User\Actions\Socialite\RedirectToLoginAction;
use Modules\User\Actions\Socialite\RegisterOauthUserAction;
use Modules\User\Actions\Socialite\RegisterSocialiteUserAction;
use Modules\User\Actions\Socialite\RetrieveOauthUserAction;
use Modules\User\Actions\Socialite\RetrieveSocialiteUserAction;
use Modules\User\Actions\Socialite\SetDefaultRolesBySocialiteUserAction;
use Modules\User\Actions\Socialite\ValidateProviderAction;
use Modules\User\Events\RegistrationNotEnabled;
use Modules\User\Events\UserNotAllowed;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

class ProcessCallbackController extends Controller
{
    /**
     * Undocumented function.
     */
    public function __invoke(Request $_request, string $provider): RedirectResponse
    {
        // See if provider exists
        // if (! app(IsProviderConfiguredAction::class)->execute($provider)) {
        //    throw ProviderNotConfigured::make($provider);
        // }
        app(ValidateProviderAction::class)->execute($provider);

        // Try to retrieve existing user
        $oauthUser = app(RetrieveOauthUserAction::class)->execute($provider);
        if ($oauthUser === null) {
            return app(RedirectToLoginAction::class)->execute('auth.login-failed');
        }

        // Verify if user is allowed
        if (! app(IsUserAllowedAction::class)->execute($oauthUser)) {
            UserNotAllowed::dispatch($oauthUser);

            return app(RedirectToLoginAction::class)->execute('auth.user-not-allowed');
        }

        // Try to find a socialite user
        $socialiteUser = app(RetrieveSocialiteUserAction::class)->execute($provider, $oauthUser);
        if ($socialiteUser) {
            $socialiteUserObj = $socialiteUser->user;
            if ($socialiteUserObj === null || ! $socialiteUserObj->canAccessSocialite()) {
                return app(RedirectToLoginAction::class)->execute('auth.user-not-allowed');
            }
            // Associate default roles to the existing "real" user, if needed
            app(SetDefaultRolesBySocialiteUserAction::class, [
                'provider' => $provider,
            ])->execute($socialiteUserObj, $oauthUser);

            return app(LoginUserAction::class)->execute($socialiteUser);
        }

        // See if registration is allowed
        if (! app(IsRegistrationEnabledAction::class)->execute()) {
            RegistrationNotEnabled::dispatch($provider, $oauthUser);

            return app(RedirectToLoginAction::class)->execute('auth.registration-not-enabled');
        }

        $user_class = XotData::make()->getUserClass();
        // See if a user already exists, but not for this socialite provider
        // $user = app()->call($this->socialite->getUserResolver(), ['provider' => $provider, 'oauthUser' => $oauthUser, 'socialite' => $this->socialite]);
        /** @var UserContract|null */
        $user = $user_class::query()->firstWhere(['email' => $oauthUser->getEmail()]);

        // Handle registration
        if ($user !== null) {
            $socialiteUser = app(RegisterSocialiteUserAction::class)->execute($provider, $oauthUser, $user);
        } else {
            $socialiteUser = app(RegisterOauthUserAction::class)->execute($provider, $oauthUser);
        }

        $socialiteUserObj = $socialiteUser->user;
        if ($socialiteUserObj === null || ! $socialiteUserObj->canAccessSocialite()) {
            return app(RedirectToLoginAction::class)->execute('auth.user-not-allowed');
        }

        // Verifichiamo prima se l'utente può accedere al socialite
        /** @var UserContract|null $authUser */
        $authUser = Auth::user();
        if ($authUser !== null && method_exists($authUser, 'canAccessSocialite') && ! $authUser->canAccessSocialite()) {
            return redirect()->route(
                optional(Auth::check()) ? 'filament.user.pages.dashboard' : 'filament.user.auth.login',
            );
        }

        return app(LoginUserAction::class)->execute($socialiteUser);
    }
}
