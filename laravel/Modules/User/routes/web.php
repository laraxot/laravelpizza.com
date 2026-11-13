<?php

declare(strict_types=1);
/**
 * @see https://github.com/DutchCodingCompany/filament-socialite/blob/main/routes/web.php
 */
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Auth\EmailVerificationController;
use Modules\User\Http\Volt\LogoutAction;

// POST + auth: un logout via GET sarebbe esposto a CSRF; gli header usano un form con @csrf.
Route::post('logout', [LogoutAction::class, '__invoke'])->middleware('auth')->name('logout');

// Link firmato della mail di verifica (PRD-02): `VerifyEmail` genera l'URL con `URL::temporarySignedRoute('verification.verify')`.
// Senza prefisso `{lang}`: il link resta valido qualunque sia la lingua; `auth` rimanda al login e poi di nuovo qui.
// La pagina `verification.notice` e' la Folio `pages/auth/verify.blade.php` di questo modulo (`/{lang}/auth/verify`).
Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

// OAuth Socialite routes live in their own file and must be loaded by the
// module web route entrypoint so the front-office route names are available.
require __DIR__.'/socialite.php';

// Route::get('/upgrade', 'UpgradeController');
