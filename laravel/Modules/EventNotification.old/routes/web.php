<?php

use Illuminate\Support\Facades\Route;
use Modules\EventNotification\App\Http\Controllers\EventNotificationController;

Route::prefix('event-notification')->group(function () {
    Route::get('/', [EventNotificationController::class, 'index'])->name('event-notification.index');
    Route::get('/create', [EventNotificationController::class, 'create'])->name('event-notification.create');
    Route::post('/', [EventNotificationController::class, 'store'])->name('event-notification.store');
    Route::get('/{eventNotification}', [EventNotificationController::class, 'show'])->name('event-notification.show');
    Route::get('/{eventNotification}/edit', [EventNotificationController::class, 'edit'])->name('event-notification.edit');
    Route::put('/{eventNotification}', [EventNotificationController::class, 'update'])->name('event-notification.update');
    Route::delete('/{eventNotification}', [EventNotificationController::class, 'destroy'])->name('event-notification.destroy');
});