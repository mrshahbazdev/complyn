<?php

use Illuminate\Support\Facades\Route;
use Modules\Docs\Http\Controllers\DocsController;

Route::middleware(['auth', 'verified', 'module:docs'])->prefix('docs')->name('docs.')->group(function () {
    Route::get('/', [DocsController::class, 'index'])->name('index');
    Route::post('/', [DocsController::class, 'store'])->name('store');
    Route::get('/create', [DocsController::class, 'create'])->name('create');
    Route::get('/{document}', [DocsController::class, 'show'])->name('show');
    Route::put('/{document}', [DocsController::class, 'update'])->name('update');
    Route::delete('/{document}', [DocsController::class, 'destroy'])->name('destroy');
    Route::post('/{document}/versions', [DocsController::class, 'uploadVersion'])->name('versions.upload');
    Route::get('/{document}/versions/{version}/download', [DocsController::class, 'download'])->name('versions.download');
});
