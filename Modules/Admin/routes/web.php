<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\McpTokenController;
use Modules\Admin\Http\Controllers\TaxonomyController;

Route::middleware(['auth', 'verified', 'platform.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('companies', [AdminController::class, 'companies'])->name('companies');
    Route::post('companies', [AdminController::class, 'storeCompany'])->name('companies.store');
    Route::put('companies/{company}', [AdminController::class, 'updateCompany'])->name('companies.update');
    Route::delete('companies/{company}', [AdminController::class, 'destroyCompany'])->name('companies.destroy');
    Route::put('companies/{company}/modules/{module}', [AdminController::class, 'toggleCompanyModule'])->name('companies.modules.toggle');

    Route::get('users', [AdminController::class, 'users'])->name('users');
    Route::post('users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::post('users/{user}/attach-company', [AdminController::class, 'attachCompany'])->name('users.attach');

    Route::get('plans', [AdminController::class, 'plans'])->name('plans');
    Route::post('plans', [AdminController::class, 'storePlan'])->name('plans.store');
    Route::put('plans/{plan}', [AdminController::class, 'updatePlan'])->name('plans.update');
    Route::put('plans/{plan}/modules/{module}', [AdminController::class, 'togglePlanModule'])->name('plans.modules.toggle');

    Route::get('modules', [AdminController::class, 'modules'])->name('modules');
    Route::put('modules/{module}', [AdminController::class, 'updateModule'])->name('modules.update');

    Route::get('taxonomy', [TaxonomyController::class, 'index'])->name('taxonomy');
    Route::post('taxonomy/{type}', [TaxonomyController::class, 'store'])->name('taxonomy.store');
    Route::delete('taxonomy/{type}/{id}', [TaxonomyController::class, 'destroy'])->name('taxonomy.destroy');

    Route::get('mcp-tokens', [McpTokenController::class, 'index'])->name('mcp.index');
    Route::post('mcp-tokens', [McpTokenController::class, 'store'])->name('mcp.store');
    Route::delete('mcp-tokens/{mcpToken}', [McpTokenController::class, 'destroy'])->name('mcp.destroy');
    Route::get('audit-logs', [McpTokenController::class, 'auditLogs'])->name('audit');
});
