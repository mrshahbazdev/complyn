<?php

use Illuminate\Support\Facades\Route;
use Modules\Exchange\Http\Controllers\ExchangeController;

Route::middleware(['auth', 'verified'])->prefix('exchange')->name('exchange.')->group(function () {
    Route::get('/', [ExchangeController::class, 'index'])->name('index');
    Route::post('/listings', [ExchangeController::class, 'store'])->name('store');
    Route::post('/listings/{listing}/inquire', [ExchangeController::class, 'inquire'])->name('inquire');
    Route::put('/listings/{listing}/close', [ExchangeController::class, 'close'])->name('close');
});
