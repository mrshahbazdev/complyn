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

Route::middleware(['auth', 'verified', 'module:core'])->group(function () {
    Route::get('/obligations', [Modules\Core\Http\Controllers\CoreComplianceController::class, 'obligations'])->name('core.obligations');
    Route::post('/obligations', [Modules\Core\Http\Controllers\CoreComplianceController::class, 'storeObligation'])->name('core.obligations.store');
    Route::put('/obligations/{obligation}/status', [Modules\Core\Http\Controllers\CoreComplianceController::class, 'updateObligationStatus'])->name('core.obligations.status');
    Route::post('/obligations/{obligation}/assign', [Modules\Core\Http\Controllers\CoreComplianceController::class, 'assignResponsible'])->name('core.obligations.assign');
    Route::get('/deadlines', [Modules\Core\Http\Controllers\CoreComplianceController::class, 'deadlines'])->name('core.deadlines');
    Route::post('/deadlines', [Modules\Core\Http\Controllers\CoreComplianceController::class, 'storeDeadline'])->name('core.deadlines.store');
    Route::put('/deadlines/{deadline}/toggle', [Modules\Core\Http\Controllers\CoreComplianceController::class, 'toggleDeadline'])->name('core.deadlines.toggle');
    Route::delete('/deadlines/{deadline}', [Modules\Core\Http\Controllers\CoreComplianceController::class, 'destroyDeadline'])->name('core.deadlines.destroy');
    Route::get('/tasks', [Modules\Core\Http\Controllers\CoreComplianceController::class, 'tasks'])->name('core.tasks');
    Route::post('/tasks', [Modules\Core\Http\Controllers\CoreComplianceController::class, 'storeTask'])->name('core.tasks.store');
    Route::put('/tasks/{task}/toggle', [Modules\Core\Http\Controllers\CoreComplianceController::class, 'toggleTask'])->name('core.tasks.toggle');
    Route::delete('/tasks/{task}', [Modules\Core\Http\Controllers\CoreComplianceController::class, 'destroyTask'])->name('core.tasks.destroy');
    Route::get('/evidences', [Modules\Core\Http\Controllers\CoreComplianceController::class, 'evidences'])->name('core.evidences');
    Route::post('/evidences', [Modules\Core\Http\Controllers\CoreComplianceController::class, 'storeEvidence'])->name('core.evidences.store');
    Route::delete('/evidences/{evidence}', [Modules\Core\Http\Controllers\CoreComplianceController::class, 'destroyEvidence'])->name('core.evidences.destroy');
});
