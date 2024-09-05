<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TramitesController;
use App\Http\Controllers\DependenciasController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SubtramitesController;
use App\Http\Controllers\CalendariosController;
use App\Http\Controllers\FechasController;
use App\Http\Controllers\HorasController;
use App\Http\Controllers\HorarioController;

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) { return $request->user();});

Route::resource('tramites', TramitesController::class);
Route::post('/guardar-datos', 'TramitesController@guardarDatos');
Route::get('/obtener-opciones', 'TramitesController@obtenerDatos');

Route::resource('subtramites', SubtramitesController::class);
Route::post('/guarda-datoss', 'SubtramitesController@guardarDatosub');

Route::resource('dependencias', DependenciasController::class);
Route::post('/guarda-datos', 'DependenciasController@guardaDatos');

Route::resource('area', AreasController::class);
Route::post('/guarda-dato', 'AreasController@guardaDato');

Route::resource('usuarios', UsersController::class);
Route::post('/guardar-da', 'UsersController@guarDatos');

Route::resource('fechas', FechasController::class);
Route::post('/guarda-datossas', 'FechasController@guardarDatosfech');

Route::resource('horas', HorasController::class);
Route::post('/guarda-datoshoras', 'HorasController@guardarDatoshoraa');

Route::resource('horarios_desglose', HorarioController::class);
Route::post('/guarda-datoshorarios', 'HorarioController@guardarDatohorarios');

Route::resource('calendarios', CalendariosController::class);
Route::post('/guarda-datosscit', [CalendariosController::class,"store"])->name('guardarDatoscitStore');


