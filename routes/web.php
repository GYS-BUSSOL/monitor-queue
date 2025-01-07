<?php

use App\Http\Controllers\MonitorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MonitorController::class, 'showMonitor']);
Route::get('/waiting', [MonitorController::class, 'showWaiting']);

Route::get('/get-monitor', [MonitorController::class, 'monitor']);
Route::get('/get-waiting', [MonitorController::class, 'waiting']);
