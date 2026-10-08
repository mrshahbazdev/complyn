<?php

use App\Http\Controllers\McpController;
use App\Http\Middleware\McpAuthenticate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| COMPLYN MCP API — token-gated platform control (Phase 0 scaffold).
| Every request is written to mcp_audit_logs by the middleware.
|--------------------------------------------------------------------------
*/

Route::prefix('mcp')->group(function () {
    Route::middleware(McpAuthenticate::class)->group(function () {
        Route::get('health', [McpController::class, 'health']);
        Route::get('blocks', [McpController::class, 'blocks']);
        Route::get('modules', [McpController::class, 'modules']);
        Route::get('schema', [McpController::class, 'schema']);
        Route::get('audit-logs', [McpController::class, 'auditLogs']);
    });

    Route::middleware(McpAuthenticate::class.':content')->group(function () {
        Route::post('modules/{key}/status', [McpController::class, 'setModuleStatus']);
    });

    Route::middleware(McpAuthenticate::class.':full')->group(function () {
        Route::post('artisan', [McpController::class, 'artisan']);
    });
});
