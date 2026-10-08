<?php

use Illuminate\Support\Facades\Route;
use Modules\Community\Http\Controllers\CommunityController;

Route::middleware(['auth', 'verified'])->prefix('community')->name('community.')->group(function () {
    Route::get('/', [CommunityController::class, 'index'])->name('index');
    Route::post('/posts', [CommunityController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [CommunityController::class, 'show'])->name('show');
    Route::post('/posts/{post}/comments', [CommunityController::class, 'comment'])->name('comments.store');
    Route::post('/groups', [CommunityController::class, 'storeGroup'])->name('groups.store');
});
