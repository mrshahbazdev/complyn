<?php

use Illuminate\Support\Facades\Route;
use Modules\Score\Http\Controllers\ScoreController;

Route::middleware(['auth', 'verified'])->prefix('score')->name('score.')->group(function () {
    Route::get('/', [ScoreController::class, 'index'])->name('index');
    Route::post('/metrics', [ScoreController::class, 'storeMetric'])->name('metrics.store');
    Route::post('/reports', [ScoreController::class, 'generateReport'])->name('reports.generate');
});
