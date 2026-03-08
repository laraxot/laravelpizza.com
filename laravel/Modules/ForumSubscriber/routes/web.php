<?php

use Illuminate\Support\Facades\Route;
use Modules\ForumSubscriber\App\Http\Controllers\ForumSubscriberController;

Route::prefix('forum-subscriber')->group(function () {
    Route::get('/', [ForumSubscriberController::class, 'index'])->name('forum-subscriber.index');
    Route::get('/create', [ForumSubscriberController::class, 'create'])->name('forum-subscriber.create');
    Route::post('/', [ForumSubscriberController::class, 'store'])->name('forum-subscriber.store');
    Route::get('/{forumSubscriber}', [ForumSubscriberController::class, 'show'])->name('forum-subscriber.show');
    Route::get('/{forumSubscriber}/edit', [ForumSubscriberController::class, 'edit'])->name('forum-subscriber.edit');
    Route::put('/{forumSubscriber}', [ForumSubscriberController::class, 'update'])->name('forum-subscriber.update');
    Route::delete('/{forumSubscriber}', [ForumSubscriberController::class, 'destroy'])->name('forum-subscriber.destroy');
});