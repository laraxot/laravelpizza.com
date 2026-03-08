<?php

use Illuminate\Support\Facades\Route;
use Modules\EventAnalytics\App\Http\Controllers\EventAnalyticsController;

Route::prefix('event-analytics')->group(function () {
    Route::get('/', [EventAnalyticsController::class, 'index'])->name('event-analytics.index');
    Route::get('/create', [EventAnalyticsController::class, 'create'])->name('event-analytics.create');
    Route::post('/', [EventAnalyticsController::class, 'store'])->name('event-analytics.store');
    Route::get('/{eventAnalytics}', [EventAnalyticsController::class, 'show'])->name('event-analytics.show');
    Route::get('/{eventAnalytics}/edit', [EventAnalyticsController::class, 'edit'])->name('event-analytics.edit');
    Route::put('/{eventAnalytics}', [EventAnalyticsController::class, 'update'])->name('event-analytics.update');
    Route::delete('/{eventAnalytics}', [EventAnalyticsController::class, 'destroy'])->name('event-analytics.destroy');
});