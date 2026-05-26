<?php

use App\Http\Controllers\Api\LogErrorController;
use Illuminate\Support\Facades\Route;

Route::post('/{endpoint}/log-error', [LogErrorController::class, 'store'])
    ->middleware(['apikey', 'throttle:logs']);
