<?php

use Illuminate\Support\Facades\Route;
use Modules\Connect\Http\Controllers\ConnectController;

Route::middleware(['auth', 'verified', 'module:connect'])->prefix('connect')->name('connect.')->group(function () {
    Route::get('/', [ConnectController::class, 'index'])->name('index');
    Route::post('/requests', [ConnectController::class, 'store'])->name('store');
    Route::get('/requests/{connectRequest}', [ConnectController::class, 'show'])->name('show');
    Route::post('/requests/{connectRequest}/messages', [ConnectController::class, 'message'])->name('messages.store');
    Route::put('/requests/{connectRequest}/close', [ConnectController::class, 'close'])->name('close');
});
