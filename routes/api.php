<?php

use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\DocentesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/alumnos',[AlumnosController::class,'index']);
Route::get('/docentes',[DocentesController::class,'index']);
Route::get('/cursos',[CursosController::class,'index']);

Route::post('/alumnos/create',[AlumnosController::class,'create']);