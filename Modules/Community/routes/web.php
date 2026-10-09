<?php

use Illuminate\Support\Facades\Route;
use Modules\Community\Http\Controllers\CommunityController;

Route::middleware(['auth', 'verified', 'module:community'])->prefix('community')->name('community.')->group(function () {
    Route::get('/', [CommunityController::class, 'index'])->name('index');
    Route::post('/posts', [CommunityController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [CommunityController::class, 'show'])->name('show');
    Route::post('/posts/{post}/comments', [CommunityController::class, 'comment'])->name('comments.store');
    Route::post('/groups', [CommunityController::class, 'storeGroup'])->name('groups.store');
});

Route::middleware(['auth', 'verified', 'module:community'])->prefix('community')->name('community.')->group(function () {
    Route::post('/comments/{comment}/vote', [CommunityController::class, 'vote'])->name('comments.vote');
    Route::post('/posts/{post}/accept/{comment}', [CommunityController::class, 'accept'])->name('posts.accept');
});
