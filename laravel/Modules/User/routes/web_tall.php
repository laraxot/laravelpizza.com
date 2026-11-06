<?php

declare(strict_types=1);
/**
 * routes from laravel preset Tall.
 */
use Illuminate\Support\Facades\Route;
use Modules\User\Filament\Widgets\Auth\ForgotPasswordWidget;
use Modules\User\Filament\Widgets\Auth\RegisterWidget;
use Modules\User\Filament\Widgets\Auth\ResetPasswordWidget;
use Modules\User\Http\Controllers\Auth\EmailVerificationController;
use Modules\User\Http\Volt\LogoutAction;
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
    Route::middleware('guest')->group(static function (): void {
        Route::get('register', RegisterWidget::class)->name('register');
    });

    Route::middleware([])->group(static function (): void {
        Route::get('password/reset', ForgotPasswordWidget::class)->name('password.request');
        Route::get('password/reset/{token}', ResetPasswordWidget::class)->name('password.reset');
    });

    Route::middleware('auth')->group(static function (): void {
        $notice = Route::get('email/verify', static fn () => redirect()->intended('/admin'));
        Assert::isInstanceOf($notice, Illuminate\Routing\Route::class);
        $notice->middleware('throttle:6,1');
        $notice->name('verification.notice');

        $confirm = Route::get('password/confirm', static fn () => redirect()->intended('/admin'));
        Assert::isInstanceOf($confirm, Illuminate\Routing\Route::class);
        $confirm->name('password.confirm');
    });

    Route::middleware('auth')
        // ->namespace('\Modules\User\Http\Livewire\Auth')
        ->group(static function (): void {
            $route = Route::get('email/verify/{id}/{hash}', EmailVerificationController::class);
            Assert::isInstanceOf($route, Illuminate\Routing\Route::class);
            $route->middleware('signed');
            $route->name('verification.verify');

            Route::match(['get', 'post'], 'logout', LogoutAction::class)->name('logout');
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

        // OAuth callback is the Sixteen Folio page; this legacy route file must not reintroduce a controller callback.
    });
