<?php

use Illuminate\Support\Facades\Route;
use Modules\Creator\Http\Controllers\CreatorController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('creators', CreatorController::class)->names('creator');
});
