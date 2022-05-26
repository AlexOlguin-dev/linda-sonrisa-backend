<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Controllers\EspecialistasController;
use App\Http\Controllers\CitaAgendadaController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\AdministrativosController;
use App\Http\Controllers\TratamientosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//LOGIN ADMIN
Route::get('/admin_login', [AdminController::class, 'login']);
//LOGIN CLIENTE
Route::get('/login', [UserController::class, 'login']);
Route::get('/reg_paciente', [UserController::class, 'registrar_paciente']);
Route::get('/list_paciente', [UserController::class, 'list_pacientes']);
Route::get('/delete_paciente', [UserController::class, 'delete_paciente']);
//MAIN
Route::get('/especialidades', [EspecialidadesController::class, 'list_especialidades']);
Route::get('/especialistas', [EspecialistasController::class, 'list_especialistas']);
Route::get('/especialistas_especialidades', [EspecialistasController::class, 'list_especialistas_segun_especialidad']);
Route::get('/nombre_especialistas', [EspecialistasController::class, 'get_name_especialista']);
Route::get('/nombre_especialidad', [EspecialidadesController::class, 'get_name_especialidad']);
//CITAS AGENDADAS CLIENTE
Route::get('/citas_tomadas_segun_cliente', [CitaAgendadaController::class, 'get_citas_tomadas_segun_cliente']);
Route::get('/citas_tomadas', [CitaAgendadaController::class, 'get_taken_citas']);
Route::get('/agendar_cita', [CitaAgendadaController::class, 'agendar_cita']);
Route::get('/delete_cita', [CitaAgendadaController::class, 'delete_cita_agendada']);
//ESPECIALISTAS
Route::get('/crear_especialista', [EspecialistasController::class, 'create_especialista']);
Route::get('/eliminar_especialista', [EspecialistasController::class, 'eliminar_especialistas']);
//PROVEEDORES
Route::get('/proveedores', [ProveedoresController::class, 'get_proveedores']);
Route::get('/crear_proveedor', [ProveedoresController::class, 'create_proveedor']);
Route::get('/eliminar_proveedor', [ProveedoresController::class, 'delete_proveedor']);
//ADMINISTRATIVOS
Route::get('/administrativos', [AdministrativosController::class, 'get_administrativos']);
Route::get('/crear_administrativos', [AdministrativosController::class, 'create_administrativo']);
Route::get('/delete_administrativos', [AdministrativosController::class, 'delete_administrativo']);
//TRATAMIENTOS
Route::get('/tratamientos', [TratamientosController::class, 'get_tratamientos']);
Route::get('/crear_tratamientos', [TratamientosController::class, 'create_tratamiento']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/datos', function () {
  return DB::select('select * from paciente');
});
