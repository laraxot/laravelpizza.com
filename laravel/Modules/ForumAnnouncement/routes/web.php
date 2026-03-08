<?php

use Illuminate\Support\Facades\Route;
use Modules\ForumAnnouncement\App\Http\Controllers\ForumAnnouncementController;

Route::prefix('forum-announcement')->group(function () {
    Route::get('/', [ForumAnnouncementController::class, 'index'])->name('forum-announcement.index');
    Route::get('/create', [ForumAnnouncementController::class, 'create'])->name('forum-announcement.create');
    Route::post('/', [ForumAnnouncementController::class, 'store'])->name('forum-announcement.store');
    Route::get('/{forumAnnouncement}', [ForumAnnouncementController::class, 'show'])->name('forum-announcement.show');
    Route::get('/{forumAnnouncement}/edit', [ForumAnnouncementController::class, 'edit'])->name('forum-announcement.edit');
    Route::put('/{forumAnnouncement}', [ForumAnnouncementController::class, 'update'])->name('forum-announcement.update');
    Route::delete('/{forumAnnouncement}', [ForumAnnouncementController::class, 'destroy'])->name('forum-announcement.destroy');
});