<?php

use Illuminate\Support\Facades\Route;
use Modules\Library\Http\Controllers\LibraryController;

Route::middleware(['auth', 'verified', 'module:library'])->prefix('library')->name('library.')->group(function () {
    Route::get('/', [LibraryController::class, 'index'])->name('index');
    Route::post('/articles', [LibraryController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}', [LibraryController::class, 'show'])->name('show');
    Route::get('/templates/{template}', [LibraryController::class, 'template'])->name('template');
    Route::get('/templates/{template}/download', [LibraryController::class, 'downloadTemplate'])->name('template.download');
});
