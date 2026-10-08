<?php

use Illuminate\Support\Facades\Route;
use Modules\Creator\Http\Controllers\CreatorController;

Route::middleware(['auth', 'verified', 'module:creator'])->prefix('creator')->name('creator.')->group(function () {
    Route::get('/', [CreatorController::class, 'index'])->name('index');
    Route::post('/drafts', [CreatorController::class, 'store'])->name('drafts.store');
    Route::post('/drafts/{draft}/generate', [CreatorController::class, 'generate'])->name('drafts.generate');
    Route::put('/drafts/{draft}', [CreatorController::class, 'update'])->name('drafts.update');
});
