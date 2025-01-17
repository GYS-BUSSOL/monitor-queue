<?php

use App\Http\Controllers\MonitorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MonitorController::class, 'showMonitor']);
Route::get('/waiting', [MonitorController::class, 'showWaiting']);
Route::get('/information', function(){
  return view('queue');
});

Route::get('/get-waiting', [MonitorController::class, 'waiting']);
