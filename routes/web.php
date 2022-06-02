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
use App\Http\Controllers\ProductoController;

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
//LOGIN ESPECIALISTA
Route::get('/especialista_login', [EspecialistasController::class, 'login']);
//LOGIN CLIENTE
Route::get('/login', [UserController::class, 'login']);
//MAIN
Route::get('/especialistas', [EspecialistasController::class, 'list_especialistas']);
Route::get('/especialistas_especialidades', [EspecialistasController::class, 'list_especialistas_segun_especialidad']);
Route::get('/nombre_especialistas', [EspecialistasController::class, 'get_name_especialista']);
//ESPECIALIDADES
Route::get('/especialidades', [EspecialidadesController::class, 'list_especialidades']);
Route::get('/nombre_especialidad', [EspecialidadesController::class, 'get_name_especialidad']);
//CITAS AGENDADAS CLIENTE
Route::get('/citas_tomadas_segun_cliente', [CitaAgendadaController::class, 'get_citas_tomadas_segun_cliente']);
Route::get('/citas_tomadas', [CitaAgendadaController::class, 'get_taken_citas']);
Route::get('/agendar_cita', [CitaAgendadaController::class, 'agendar_cita']);
Route::get('/delete_cita', [CitaAgendadaController::class, 'delete_cita_agendada']);
Route::get('/all_citas', [CitaAgendadaController::class, 'get_all_cita_agendada']);
Route::get('/get_citas_especialista', [CitaAgendadaController::class, 'list_citas_agendadas_especialista']);
//ESPECIALISTAS
Route::get('/crear_especialista', [EspecialistasController::class, 'create_especialista']);
Route::get('/eliminar_especialista', [EspecialistasController::class, 'eliminar_especialistas']);
Route::get('/full_eliminar_especialista', [EspecialistasController::class, 'full_eliminar_especialistas']);
//PROVEEDORES
Route::get('/proveedores', [ProveedoresController::class, 'get_proveedores']);
Route::get('/crear_proveedor', [ProveedoresController::class, 'create_proveedor']);
Route::get('/eliminar_proveedor', [ProveedoresController::class, 'delete_proveedor']);
Route::get('/full_eliminar_proveedor', [ProveedoresController::class, 'full_delete_proveedor']);
//ADMINISTRATIVOS
Route::get('/administrativos', [AdministrativosController::class, 'get_administrativos']);
Route::get('/crear_administrativos', [AdministrativosController::class, 'create_administrativo']);
Route::get('/delete_administrativos', [AdministrativosController::class, 'delete_administrativo']);
//TRATAMIENTOS
Route::get('/tratamientos_main_page', [TratamientosController::class, 'get_tratamientos_main_page']);
Route::get('/tratamientos', [TratamientosController::class, 'get_tratamientos']);
Route::get('/crear_tratamientos', [TratamientosController::class, 'create_tratamiento']);
Route::get('/delete_tratamientos', [TratamientosController::class, 'delete_tratamiento']);
//PRODUCTOS
Route::get('/productos', [ProductoController::class, 'list_productos']);
Route::get('/create_productos', [ProductoController::class, 'create_producto']);
Route::get('/delete_productos', [ProductoController::class, 'delete_producto']);
Route::get('/asign_productos_proveedores', [ProductoController::class, 'asign_producto_proveedor']);
Route::get('/get_productos_asignados', [ProductoController::class, 'get_productos_asignados']);
Route::get('/find_producto_by_name', [ProductoController::class, 'find_producto_by_name']);
Route::get('/find_all_producto_by_name', [ProductoController::class, 'get_all_products_by_name']);
//PACIENTE
Route::get('/reg_paciente', [UserController::class, 'registrar_paciente']);
Route::get('/list_paciente', [UserController::class, 'list_pacientes']);
Route::get('/delete_paciente', [UserController::class, 'delete_paciente']);
Route::get('/get_pacientes_segun_especialista', [UserController::class, 'get_pacientes_segun_especialista']);


Route::get('/', function () {
    return view('welcome');
});

Route::get('/datos', function () {
  return DB::select('select * from paciente');
});
