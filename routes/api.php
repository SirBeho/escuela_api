<?php

use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\DocentesController;
use App\Http\Controllers\SeleccionesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/docentes', [DocentesController::class, 'index']);


Route::group(['prefix' => 'alumnos'], function () {
    Route::get('/', [AlumnosController::class, 'index']);
    Route::post('/seleccion', [SeleccionesController::class, 'create']);
    Route::delete('/seleccion', [SeleccionesController::class, 'destroy']);
    Route::post('/create', [AlumnosController::class, 'create']);
    Route::get('/{id}', [AlumnosController::class, 'show']);
    Route::put('/{id}', [AlumnosController::class, 'update']);
    Route::delete('/{id}', [AlumnosController::class, 'destroy']);
});

Route::group(['prefix' => 'docentes'], function () {
    Route::get('/', [DocentesController::class, 'index']);
    Route::post('/create', [DocentesController::class, 'create']);
    Route::get('/{id}', [DocentesController::class, 'show']);
    Route::put('/{id}', [DocentesController::class, 'update']);
    Route::delete('/{id}', [DocentesController::class, 'destroy']);
});

Route::group(['prefix' => 'cursos'], function () {
    Route::get('/', [CursosController::class, 'index']);
    Route::post('/create', [CursosController::class, 'create']);
    Route::get('/{id}', [CursosController::class, 'show']);
    Route::put('/{id}', [CursosController::class, 'update']);
    Route::delete('/{id}', [CursosController::class, 'destroy']);
});
