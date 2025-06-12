<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CentroMiddleware;
use App\Http\Middleware\DonanteMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CentroController;
use App\Http\Controllers\Api\HorarioCentroController;
use App\Http\Controllers\Api\CitaController;

/* RUTAS PERSONALIZADAS */

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 📌 RUTAS PÚBLICAS
Route::get('/centros', [CentroController::class, 'index']);
