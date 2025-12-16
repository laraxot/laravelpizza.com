<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite/blob/main/routes/web.php
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Auth\LogoutController;
use Modules\Xot\Datas\XotData;

require 'socialite.php';

if (XotData::make()->register_pub_theme) {
    // require 'web_tall.php';
} else {
    Route::get('/login', static fn () => redirect('/admin/login'))->name('login');
}

Route::post('/logout', LogoutController::class)->name('logout');

// Route::get('/upgrade', 'UpgradeController');
