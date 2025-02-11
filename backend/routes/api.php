<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoverController;

Log::info('Cargando rutas API');

Route::post('/move', [RoverController::class, 'move']);
Route::get('/obstacles', [RoverController::class, 'getObstacles']);

Route::get('/test', function() {
    return response()->json(['message' => 'API is working']);
});
