<?php

use Illuminate\Support\Facades\Route;
use Modules\Academy\Http\Controllers\AcademyController;

Route::middleware(['auth', 'verified', 'module:academy'])->prefix('academy')->name('academy.')->group(function () {
    Route::get('/', [AcademyController::class, 'index'])->name('index');
    Route::get('/courses/{course}', [AcademyController::class, 'show'])->name('show');
    Route::post('/lessons/{lesson}/complete', [AcademyController::class, 'complete'])->name('complete');
});

Route::middleware(['auth', 'verified', 'module:academy'])->prefix('academy')->name('academy.')->group(function () {
    Route::post('/lessons/{lesson}/quizzes', [AcademyController::class, 'storeQuiz'])->name('quizzes.store');
    Route::post('/lessons/{lesson}/attempt', [AcademyController::class, 'attempt'])->name('attempt');
});