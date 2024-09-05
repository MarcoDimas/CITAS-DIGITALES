<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\CalendariosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TramitesController;
use App\Http\Controllers\DependenciasController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SubtramitesController;
use App\Http\Controllers\FechasController;
use App\Http\Controllers\HorasController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\VerUsuariosController;
use Illuminate\Support\Facades\Mail;
use App\Mail\PruebaCorreo;

Route::get('/', function () { return view('welcome');});
Route::get('/users', [App\Http\Controllers\UsuariosController::class, 'index'])->name('users.index');
// Route::get('/mostrar-Formula/{solicitud?}', [CalendariosController::class, 'mostrarFormula'])
//     ->name('calendarios')
//     ->middleware('jwt.auth');



Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/menuPrincipal', [App\Http\Controllers\AuthController::class, 'verMenu'])->name('menuPrincipal')->middleware('auth');



/* CALENDARIOS */
//Route::get('/mostrar-formulario', [CalendariosController::class, 'mostrarFormulatr']);
Route::get('/calendarios', [App\Http\Controllers\CalendariosController::class, 'index'])->name('calendarios');
Route::get('/obtenerDatosfilr',  [CalendariosController::class, 'obtenerDatosFiltradoss'])->name('obtenerDatosFiltradoss');
Route::get('/obtenerDatosfilra',  [CalendariosController::class, 'obtenerDatosFiltradosstr'])->name('obtenerDatosFiltradosstr');
Route::get('/mostrar-Formula/{solicitud?}', [CalendariosController::class, 'mostrarFormula'])->name('calendarios');
Route::get('/calendarios', [App\Http\Controllers\CalendariosController::class, 'index'])->name('calendarios3');
Route::post('/calendarios', [CalendariosController::class, 'store'])->name('calendarios2');
Route::post('/guarda-datosscit',  [CalendariosController::class, 'guardarDatoscit'])->name('guardarDatoscit');
Route::get('/generarPdf',  [CalendariosController::class, 'generarPdf'])->name('generarPdf');

Route::post("/obtenerHoras",[CalendariosController::class,'getHoras'])->name("ObtenerHoras");

/* ALTA USUARIOS */
Route::get('/users', [App\Http\Controllers\UsuariosController::class, 'index'])->name('users')->middleware('auth');
Route::put('/actualizar-estatus/{id}', [UsuariosController::class, 'actualizarEstatus'])->name('actualizar.estatus');
//Route::delete('/eliminar-estatus/{id}', [UsuariosController::class, 'eliminar'])->name('eliminar.registro');
Route::put('/cancelar-cit/{id}', [UsuariosController::class, 'cancelarCita'])->name('cancelar.cita');


/* ALTA USUARIOS */
Route::get('/vusuario', [VerUsuariosController::class, 'index'])->name('vusuario')->middleware('auth');
Route::put('/actualizar-password/{id}', [VerUsuariosController::class, 'actualizarPassword'])->name('actualizar.password');
Route::put('/usuarios/{id}/desactivar', [VerUsuariosController::class, 'desactivar'])->name('usuarios.desactivar');
Route::post('/usuarios', [UsersController::class, 'store'])->name('usuarios');
Route::post('/usuarios',  [UsersController::class, 'guarDatos'])->name('guarDatos');
Route::get('/mostrarForma', [UsersController::class, 'mostrarForma'])->name('usuarios3');

/*  ALTA TRAMITES   */
Route::get('/tramites', [App\Http\Controllers\TramitesController::class, 'index'])->name('tramites2');
Route::post('/tramites', [TramitesController::class, 'store'])->name('tramites'); 
Route::post('/guardar-datos',  [TramitesController::class, 'guardarDatos'])->name('guardarDatos');
Route::get('/mostrarformu', [TramitesController::class, 'mostrarformu'])->name('tramites3')->middleware('auth');
Route::get('/obtener-opciones',  [TramitesController::class, 'obtenerTodos'])->name('obtenerTodos');
Route::get('/obtener-opciones/{categoria}',  [TramitesController::class, 'obtenerOpciones'])->name('obtenerOpciones');
Route::get('/obtenerDatosfil',  [TramitesController::class, 'obtenerDatosFiltrados'])->name('obtenerDatosFiltrados');
Route::get('/obtener-areas-por-dependencia',  [TramitesController::class, 'obtenerAreasPorDependencia'])->name('obtenerAreasPorDependencia');

/*SUBTRAMITES*******/
Route::get('/subtramite', [App\Http\Controllers\SubtramitesController::class, 'index'])->name('subtramite');
Route::post('/subtramite', [SubtramitesController::class, 'store'])->name('subtramite2');
Route::get('/mostrarFormularioss', [SubtramitesController::class, 'mostrarFormularioss'])->name('subtramite3')->middleware('auth');
Route::post('/guarda-datoss',  [SubtramitesController::class, 'guardarDatosub'])->name('guardarDatosub');

/*  ALTA DEPÉNDENCIAS   */
Route::get('/dependencias', [App\Http\Controllers\DependenciasController::class, 'index'])->name('dependencias2')->middleware('auth');
Route::post('/dependencias', [DependenciasController::class, 'store'])->name('dependencias');
Route::post('/guarda-datos',  [DependenciasController::class, 'guardaDatos'])->name('guardaDatos');

/* ALTA ÁREAS   */
Route::get('/area', [App\Http\Controllers\AreasController::class, 'index'])->name('area2');
Route::post('/area', [AreasController::class, 'store'])->name('area');
Route::post('/guarda-dato',  [AreasController::class, 'guardaDato'])->name('guardaDato');
Route::get('/mostrarFor', [AreasController::class, 'mostrarFor'])->name('area3')->middleware('auth');

/* ALTA FECHAS Y HORAS **/
Route::get('/fechas', [App\Http\Controllers\FechasController::class, 'index'])->name('fechas');
Route::get('/mostrarFormulariossa', [FechasController::class, 'mostrarFormulariossa'])->name('fechas3')->middleware('auth');
Route::post('/fechas', [FechasController::class, 'store'])->name('fechas2');
Route::post('/guarda-datossas',  [FechasController::class, 'guardarDatosfech'])->name('guardarDatosfech');

/* ALTA FECHAS Y HORAS **/
Route::get('/horas', [App\Http\Controllers\HorasController::class, 'index'])->name('horas');
Route::get('/mostrarforhor', [HorasController::class, 'mostrarforhor'])->name('horas3');
Route::post('/horas', [HorasController::class, 'store'])->name('horas2');
Route::post('/guarda-datoshoras',  [HorasController::class, 'guardarDatoshoraa'])->name('guardarDatoshoraa');

/* DESGLOSAR HORARIO **/
Route::get('/horario_desglose', [App\Http\Controllers\HorarioController::class, 'index'])->name('horario_desglose');
Route::get('/mostrarhora', [HorarioController::class, 'mostrarhora'])->name('horario_desglose3');
Route::post('/horario_desglose', [HorarioController::class, 'store'])->name('horario_desglose2');
Route::post('/guarda-datoshorarios',  [HorarioController::class, 'guardarDatohorarios'])->name('guardarDatohorarios');



// Route::get('/correo-prueba', function () {
//     Mail::to('marcodimas1234@gmail.com')->send(new PruebaCorreo());
//     return 'Correo de prueba enviado correctamente.';
// });