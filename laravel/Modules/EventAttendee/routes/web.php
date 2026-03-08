<?php

use Illuminate\Support\Facades\Route;
use Modules\EventAttendee\App\Http\Controllers\EventAttendeeController;

Route::prefix('event-attendee')->group(function () {
    Route::get('/', [EventAttendeeController::class, 'index'])->name('event-attendee.index');
    Route::get('/create', [EventAttendeeController::class, 'create'])->name('event-attendee.create');
    Route::post('/', [EventAttendeeController::class, 'store'])->name('event-attendee.store');
    Route::get('/{eventAttendee}', [EventAttendeeController::class, 'show'])->name('event-attendee.show');
    Route::get('/{eventAttendee}/edit', [EventAttendeeController::class, 'edit'])->name('event-attendee.edit');
    Route::put('/{eventAttendee}', [EventAttendeeController::class, 'update'])->name('event-attendee.update');
    Route::delete('/{eventAttendee}', [EventAttendeeController::class, 'destroy'])->name('event-attendee.destroy');
});