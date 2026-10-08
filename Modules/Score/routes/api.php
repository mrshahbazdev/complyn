<?php

use Illuminate\Support\Facades\Route;
use Modules\Score\Http\Controllers\ScoreController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('scores', ScoreController::class)->names('score');
});
