<?php

/**
 * routes from laravel preset Tall.
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Auth\EmailVerificationController;
use Modules\User\Http\Controllers\Auth\LogoutController;
use Modules\User\Http\Livewire\Auth\Passwords\Confirm;
use Modules\User\Http\Livewire\Auth\Passwords\Email;
use Modules\User\Http\Livewire\Auth\Passwords\Reset;
use Modules\User\Http\Livewire\Auth\Register;
use Modules\User\Http\Livewire\Auth\Verify;
use Webmozart\Assert\Assert;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */

// Route::view('/', 'welcome')->name('home');
Route::prefix('{lang}')->group(function (): void {
    Route::middleware('guest')
        ->namespace('\Modules\User\Http\Livewire\Auth')
        ->group(static function (): void {
            Route::get('login', 'Login')->name('login');

            Route::get('register', Register::class)->name('register');
        });

    Route::middleware([])->namespace('\Modules\User\Http\Livewire\Auth')->group(static function (): void {
        Route::get('password/reset', Email::class)->name('password.request');

        Route::get('password/reset/{token}', Reset::class)->name(
            'password.reset',
        );
    });

    Route::middleware('auth')
        ->namespace('\Modules\User\Http\Livewire\Auth')
        ->group(static function (): void {
            $route = Route::get('email/verify', Verify::class);
            Assert::isInstanceOf($route, Illuminate\Routing\Route::class);
            $route->middleware('throttle:6,1');
            $route->name('verification.notice');

            $route = Route::get('password/confirm', Confirm::class);
            Assert::isInstanceOf($route, Illuminate\Routing\Route::class);
            $route->name('password.confirm');
        });

    Route::middleware('auth')
        // ->namespace('\Modules\User\Http\Livewire\Auth')
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
            // 'LoginController@redirectToProvider',
        );
        // ->name('oauth.redirect')

        Route::get('/sso/{provider}/callback', 'ProcessCallbackController');

        // ->name('oauth.callback');
    });
