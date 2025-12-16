<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

// use Modules\Cms\Http\Controllers\PageController;
/*
 * Route::get('/{lang?}/{container0?}/{item0?}/{container1?}/{item1?}/{container2?}/{item2?}', '\\'.Welcome::class)->name('test');
 * Route::get('/', '\\'.Home::class)->name('home');
 */
// Route::get('/{container0}/{item0?}/{container1?}/{item1?}/{container2?}/{item2?}', PageController::class);

Route::get(
    '/',
    fn () => // return view('welcome');
        redirect('/'.app()->getLocale()),
);
