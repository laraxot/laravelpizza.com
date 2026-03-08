<?php

use Illuminate\Support\Facades\Route;
use Modules\EventFeedbackType\App\Http\Controllers\EventFeedbackTypeController;

Route::prefix('event-feedback-type')->group(function () {
    Route::get('/', [EventFeedbackTypeController::class, 'index'])->name('event-feedback-type.index');
    Route::get('/create', [EventFeedbackTypeController::class, 'create'])->name('event-feedback-type.create');
    Route::post('/', [EventFeedbackTypeController::class, 'store'])->name('event-feedback-type.store');
    Route::get('/{eventFeedbackType}', [EventFeedbackTypeController::class, 'show'])->name('event-feedback-type.show');
    Route::get('/{eventFeedbackType}/edit', [EventFeedbackTypeController::class, 'edit'])->name('event-feedback-type.edit');
    Route::put('/{eventFeedbackType}', [EventFeedbackTypeController::class, 'update'])->name('event-feedback-type.update');
    Route::delete('/{eventFeedbackType}', [EventFeedbackTypeController::class, 'destroy'])->name('event-feedback-type.destroy');
});