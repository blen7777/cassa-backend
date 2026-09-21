<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HaciendaController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\ResponsableController;
use Illuminate\Support\Facades\Route;

Route::get('/health', HealthController::class);

Route::get('/dashboard/summary', [DashboardController::class, 'summary']);

Route::apiResource('responsables', ResponsableController::class);

Route::apiResource('haciendas', HaciendaController::class);

Route::apiResource('haciendas.lotes', LoteController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->shallow(false);
