<?php

use Illuminate\Support\Facades\Route;
use Modules\ForumPermission\App\Http\Controllers\ForumPermissionController;

Route::prefix('forum-permission')->group(function () {
    Route::get('/', [ForumPermissionController::class, 'index'])->name('forum-permission.index');
    Route::get('/create', [ForumPermissionController::class, 'create'])->name('forum-permission.create');
    Route::post('/', [ForumPermissionController::class, 'store'])->name('forum-permission.store');
    Route::get('/{forumPermission}', [ForumPermissionController::class, 'show'])->name('forum-permission.show');
    Route::get('/{forumPermission}/edit', [ForumPermissionController::class, 'edit'])->name('forum-permission.edit');
    Route::put('/{forumPermission}', [ForumPermissionController::class, 'update'])->name('forum-permission.update');
    Route::delete('/{forumPermission}', [ForumPermissionController::class, 'destroy'])->name('forum-permission.destroy');
});