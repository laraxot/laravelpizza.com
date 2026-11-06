<?php

declare(strict_types=1);
/**
 * @see https://github.com/DutchCodingCompany/filament-socialite/blob/main/routes/web.php
 */
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Volt\LogoutAction;

// POST + auth: un logout via GET sarebbe esposto a CSRF; gli header usano un form con @csrf.
Route::post('logout', [LogoutAction::class, '__invoke'])->middleware('auth')->name('logout');

// OAuth Socialite routes live in their own file and must be loaded by the
// module web route entrypoint so the front-office route names are available.
require __DIR__.'/socialite.php';

// Route::get('/upgrade', 'UpgradeController');
