<?php

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\User\Events\RegistrationNotEnabled;
use Modules\User\Events\UserNotAllowed;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Spatie\QueueableAction\QueueableAction;

final class ProcessCallbackAction
{
    use QueueableAction;

    public function execute(string $lang, string $provider): RedirectResponse
    {
        $entryLang = session()->pull(ProcessCallbackSession::KEY);
        $supported = LaravelLocalization::getSupportedLanguagesKeys();
        app()->setLocale(is_string($entryLang) && in_array($entryLang, $supported, true) ? $entryLang : $lang);

        app(ValidateProviderAction::class)->execute($provider);
        $oauthUser = app(RetrieveOauthUserAction::class)->execute($provider);
        if ($oauthUser === null) {
            return app(RedirectToLoginAction::class)->execute('auth.login-failed');
        }
        if (! app(IsUserAllowedAction::class)->execute($oauthUser)) {
            UserNotAllowed::dispatch($oauthUser);

            return app(RedirectToLoginAction::class)->execute('auth.user-not-allowed');
        }

        $socialiteUser = app(RetrieveSocialiteUserAction::class)->execute($provider, $oauthUser);
        if ($socialiteUser) {
            return app(LoginUserAction::class)->execute($socialiteUser);
        }
        if (! app(IsRegistrationEnabledAction::class)->execute()) {
            RegistrationNotEnabled::dispatch($provider, $oauthUser);

            return app(RedirectToLoginAction::class)->execute('auth.registration-not-enabled');
        }

        $userClass = XotData::make()->getUserClass();
        /** @var UserContract|null $user */
        $user = $userClass::query()->firstWhere(['email' => $oauthUser->getEmail()]);
        $socialiteUser = $user !== null
            ? app(RegisterSocialiteUserAction::class)->execute($provider, $oauthUser, $user)
            : app(RegisterOauthUserAction::class)->execute($provider, $oauthUser);
        $socialiteUserObj = $socialiteUser->user;
        if ($socialiteUserObj === null || ! $socialiteUserObj->canAccessSocialite()) {
            return app(RedirectToLoginAction::class)->execute('auth.user-not-allowed');
        }
        /** @var UserContract|null $authUser */
        $authUser = Auth::user();
        if ($authUser !== null && method_exists($authUser, 'canAccessSocialite') && ! $authUser->canAccessSocialite()) {
            return redirect()->route(Auth::check() ? 'filament.user.pages.dashboard' : 'filament.user.auth.login');
        }

        return app(LoginUserAction::class)->execute($socialiteUser);
    }
}
