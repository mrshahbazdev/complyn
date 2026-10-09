<?php

use Illuminate\Support\Facades\Route;
use Modules\Coach\Http\Controllers\CoachController;

Route::middleware(['auth', 'verified', 'module:coach'])->prefix('coach')->name('coach.')->group(function () {
    Route::get('/', [CoachController::class, 'index'])->name('index');
    Route::post('/sessions', [CoachController::class, 'storeSession'])->name('sessions.store');
    Route::get('/sessions/{session}', [CoachController::class, 'show'])->name('show');
    Route::post('/sessions/{session}/ask', [CoachController::class, 'ask'])->name('ask');
    Route::post('/checklists', [CoachController::class, 'storeChecklist'])->name('checklists.store');
});

Route::middleware(['auth', 'verified', 'module:coach'])->prefix('coach')->name('coach.')->group(function () {
    Route::get('/recommendations', [CoachController::class, 'recommendations'])->name('recommendations');
});