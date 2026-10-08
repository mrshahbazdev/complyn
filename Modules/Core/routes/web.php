<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\CoreController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [CoreController::class, 'dashboard'])->name('dashboard');
    Route::get('/files', [CoreController::class, 'files'])->name('files.index');
    Route::post('/files', [CoreController::class, 'upload'])->name('files.upload');
    Route::delete('/files/{file}', [CoreController::class, 'destroyFile'])->name('files.destroy');
    Route::get('/files/{file}/download', [CoreController::class, 'download'])->name('files.download');
    Route::get('/notifications', [CoreController::class, 'notifications'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [CoreController::class, 'markRead'])->name('notifications.read');
    Route::get('/search', [CoreController::class, 'search'])->name('search');
    Route::get('/settings', [CoreController::class, 'settings'])->name('settings');
    Route::put('/settings/company', [CoreController::class, 'updateCompany'])->name('settings.company');
});
