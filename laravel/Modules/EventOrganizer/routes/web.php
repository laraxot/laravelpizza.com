<?php

use Illuminate\Support\Facades\Route;
use Modules\EventOrganizer\App\Http\Controllers\EventOrganizerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('event-organizer')->group(function () {
    Route::get('/', [EventOrganizerController::class, 'index']);
    Route::get('/create', [EventOrganizerController::class, 'create']);
    Route::post('/', [EventOrganizerController::class, 'store']);
    Route::get('/{id}', [EventOrganizerController::class, 'show']);
    Route::get('/{id}/edit', [EventOrganizerController::class, 'edit']);
    Route::put('/{id}', [EventOrganizerController::class, 'update']);
    Route::delete('/{id}', [EventOrganizerController::class, 'destroy']);
});