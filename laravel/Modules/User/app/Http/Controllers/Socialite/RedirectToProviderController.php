<?php

declare(strict_types=1);
/**
 * @see DutchCodingCompany\FilamentSocialite.
 */

namespace Modules\User\Http\Controllers\Socialite;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Modules\User\Actions\Socialite\ProcessCallbackSession;
use Modules\User\Actions\Socialite\ValidateProviderAction;

class RedirectToProviderController extends Controller
{
    /**
     * Route: GET /{lang}/auth/login/{provider} (oauth.redirect).
     *
     * `$lang` must be declared: with only `$provider`, Laravel binds the first
     * route segment (`it`) into `$provider` and Socialite looks up services.it.
     */
    public function __invoke(Request $request, string $lang, string $provider): RedirectResponse
    {
        unset($request);
        app()->setLocale($lang);

        // Il redirect_uri verso Google e' unico (GOOGLE_REDIRECT_URI = /it/...): senza questo, chi parte da /en/
        // rientra dal callback in italiano. ProcessCallbackAction la ripristina.
        session()->put(ProcessCallbackSession::KEY, $lang);

        app(ValidateProviderAction::class)->execute($provider);

        $redirect = Socialite::driver($provider)->redirect();

        if (! $redirect instanceof RedirectResponse) {
            throw new \RuntimeException(\sprintf('Expected %s from Socialite provider redirect(), got %s.', RedirectResponse::class, $redirect::class));
        }

        return $redirect;
    }
}
