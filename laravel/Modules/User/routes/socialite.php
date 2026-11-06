<?php

declare(strict_types=1);
/**
 * @see https://github.com/DutchCodingCompany/filament-socialite/blob/main/routes/web.php
 */
use Illuminate\Support\Facades\Route;

// `{lang}` e `{provider}` sono input pubblici: vincolati, un valore inventato e' un 404 (pagina a tema)
// e non una lingua fantasma o un 500 "provider non configurato". Provider = quelli offerti da SocialLoginWidget.
Route::prefix('{lang}')
    ->where(['lang' => implode('|', array_map('preg_quote', array_keys((array) config('laravellocalization.supportedLocales', ['it' => []]))))])
    ->group(static function (): void {
        Route::namespace('Socialite')
            ->group(static function (): void {
                Route::get(
                    '/auth/login/{provider}',
                    'RedirectToProviderController',
                )->where('provider', 'google|microsoft|github')->name('oauth.redirect');

            });
    });
