<?php

use Illuminate\Support\Facades\Route;
use Modules\Exchange\Http\Controllers\ExchangeController;

Route::middleware(['auth', 'verified', 'module:exchange'])->prefix('exchange')->name('exchange.')->group(function () {
    Route::get('/', [ExchangeController::class, 'index'])->name('index');
    Route::post('/listings', [ExchangeController::class, 'store'])->name('store');
    Route::post('/listings/{listing}/inquire', [ExchangeController::class, 'inquire'])->name('inquire');
    Route::put('/listings/{listing}/close', [ExchangeController::class, 'close'])->name('close');
});

Route::middleware(['auth', 'verified', 'module:exchange'])->prefix('exchange')->name('exchange.')->group(function () {
    Route::get('/groups', [ExchangeController::class, 'groups'])->name('groups');
    Route::post('/groups', [ExchangeController::class, 'storeGroup'])->name('groups.store');
    Route::get('/groups/{group}', [ExchangeController::class, 'group'])->name('groups.show');
    Route::post('/groups/{group}/topics', [ExchangeController::class, 'storeTopic'])->name('topics.store');
    Route::get('/topics/{topic}', [ExchangeController::class, 'topic'])->name('topics.show');
    Route::post('/topics/{topic}/comments', [ExchangeController::class, 'comment'])->name('topics.comments.store');
});