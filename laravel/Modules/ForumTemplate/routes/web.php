<?php

use Illuminate\Support\Facades\Route;
use Modules\ForumTemplate\App\Http\Controllers\ForumTemplateController;

Route::prefix('forum-template')->group(function () {
    Route::get('/', [ForumTemplateController::class, 'index'])->name('forum-template.index');
    Route::get('/create', [ForumTemplateController::class, 'create'])->name('forum-template.create');
    Route::post('/', [ForumTemplateController::class, 'store'])->name('forum-template.store');
    Route::get('/{forumTemplate}', [ForumTemplateController::class, 'show'])->name('forum-template.show');
    Route::get('/{forumTemplate}/edit', [ForumTemplateController::class, 'edit'])->name('forum-template.edit');
    Route::put('/{forumTemplate}', [ForumTemplateController::class, 'update'])->name('forum-template.update');
    Route::delete('/{forumTemplate}', [ForumTemplateController::class, 'destroy'])->name('forum-template.destroy');
});