<?php

/**
 * routes from laravel preset Tall.
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Auth\EmailVerificationController;
use Modules\User\Http\Controllers\Auth\LogoutController;
use Webmozart\Assert\Assert;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 */

Route::prefix('{lang}')->group(function (): void {
    
    Route::middleware('auth')
        ->group(static function (): void {
            $route = Route::get('email/verify/{id}/{hash}', EmailVerificationController::class);
            Assert::isInstanceOf($route, Illuminate\Routing\Route::class);
            $route->middleware('signed');
            $route->name('verification.verify');

            Route::match(['get', 'post'], 'logout', LogoutController::class)->name('logout');
        });
})->whereIn('lang', ['it', 'en']);

Route::namespace('Socialite')
    ->name('socialite.')
    ->group(static function (): void {
        Route::get(
            '/login/{provider}',
            'RedirectToProviderController',
        );

        Route::get('/sso/{provider}/callback', 'ProcessCallbackController');
    });
