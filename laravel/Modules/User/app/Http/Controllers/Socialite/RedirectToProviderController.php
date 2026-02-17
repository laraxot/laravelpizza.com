<?php

declare(strict_types=1);

/**
 * @see DutchCodingCompany\FilamentSocialite.
 */

namespace Modules\User\Http\Controllers\Socialite;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use Laravel\Socialite\Facades\Socialite;
use Modules\User\Actions\Socialite\GetProviderScopesAction;
use Modules\User\Actions\Socialite\ValidateProviderAction;

class RedirectToProviderController extends Controller
{
    /**
     * Undocumented function.
     */
    public function __invoke(Request $_request, string $provider): RedirectResponse
    {
        // if (! app(IsProviderConfiguredAction::class)->execute($provider)) {
        //    throw ProviderNotConfigured::make($provider);
        // }
        app(ValidateProviderAction::class)->execute($provider);

        $scopes = app(GetProviderScopesAction::class)->execute($provider);
        $socialiteProvider = Socialite::with($provider);
        if (! is_object($socialiteProvider)) {
            throw new \Exception('wip');
        }

        // @phpstan-ignore-next-line function.alreadyNarrowedType (Explicit check for Socialite provider methods)
        if (! method_exists($socialiteProvider, 'scopes') || ! method_exists($socialiteProvider, 'redirect')) {
            throw new \Exception('scopes/redirect methods not available');
        }

        // PHPStan Level 10: Type guard for socialite provider chaining
        // @phpstan-ignore-next-line function.alreadyNarrowedType (Check needed for both scopes and redirect)
        $scopedProvider = $socialiteProvider->scopes($scopes);

        if (! is_object($scopedProvider) || ! method_exists($scopedProvider, 'redirect')) {
            throw new \Exception('scopes() must return object with redirect method');
        }

        /** @phpstan-ignore-next-line method.notFound (Socialite dynamic provider) */
        $redirectResult = $scopedProvider->redirect();

        if (! $redirectResult instanceof RedirectResponse) {
            throw new \Exception('Expected RedirectResponse from socialite provider');
        }

        return $redirectResult;
    }
}
