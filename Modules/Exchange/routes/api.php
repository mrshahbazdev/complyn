<?php

use Illuminate\Support\Facades\Route;
use Modules\Exchange\Http\Controllers\ExchangeController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('exchanges', ExchangeController::class)->names('exchange');
});
