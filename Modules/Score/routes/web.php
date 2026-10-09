<?php

use Illuminate\Support\Facades\Route;
use Modules\Score\Http\Controllers\ScoreController;

Route::middleware(['auth', 'verified', 'module:score'])->prefix('score')->name('score.')->group(function () {
    Route::get('/', [ScoreController::class, 'index'])->name('index');
    Route::post('/metrics', [ScoreController::class, 'storeMetric'])->name('metrics.store');
    Route::post('/reports', [ScoreController::class, 'generateReport'])->name('reports.generate');
});

Route::middleware(['auth', 'verified', 'module:score'])->prefix('score')->name('score.')->group(function () {
    Route::get('/leaderboard', [ScoreController::class, 'leaderboard'])->name('leaderboard');
});