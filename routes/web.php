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
use App\Http\Controllers\OrdenPedidoController;
use App\Http\Controllers\TratamientosAgendadosController;
use App\Http\Controllers\DiagnosticoController;
use App\Http\Controllers\BoletasController;
use App\Http\Controllers\InformesController;

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
//LOGIN ADMINISTRATIVO
Route::get('/administrativo_login', [AdministrativosController::class, 'login']);
//MAIN
Route::get('/especialistas', [EspecialistasController::class, 'list_especialistas']);
Route::get('/especialistas_especialidades', [EspecialistasController::class, 'list_especialistas_segun_especialidad']);
Route::get('/nombre_especialistas', [EspecialistasController::class, 'get_name_especialista']);
//ESPECIALIDADES
Route::get('/especialidades', [EspecialidadesController::class, 'list_especialidades']);
Route::get('/nombre_especialidad', [EspecialidadesController::class, 'get_name_especialidad']);
Route::get('/create_especialidad_especialista', [EspecialidadesController::class, 'create_especialidad_especialista']);
Route::get('/get_especialidades_especialista', [EspecialidadesController::class, 'get_especialidades_especialista']);
Route::get('/delete_especialidad_especialista', [EspecialidadesController::class, 'delete_especialidad_especialista']);
//CITAS AGENDADAS
Route::get('/citas_tomadas_segun_cliente', [CitaAgendadaController::class, 'get_citas_tomadas_segun_cliente']);
Route::get('/citas_tomadas', [CitaAgendadaController::class, 'get_taken_citas']);
Route::get('/agendar_cita', [CitaAgendadaController::class, 'agendar_cita']);
Route::get('/delete_cita', [CitaAgendadaController::class, 'delete_cita_agendada']);
Route::get('/all_citas', [CitaAgendadaController::class, 'get_all_cita_agendada']);
Route::get('/get_citas_especialista', [CitaAgendadaController::class, 'list_citas_agendadas_especialista']);
Route::get('/search_cita_agendada', [CitaAgendadaController::class, 'search_cita_agendada']);
Route::get('/search_cita_agendada_administrativo', [CitaAgendadaController::class, 'search_cita_agendada_administrativo']);
Route::get('/get_citas_agendadas_sin_boleta', [CitaAgendadaController::class, 'get_citas_agendadas_sin_boleta']);
//ESPECIALISTAS
Route::get('/crear_especialista', [EspecialistasController::class, 'create_especialista']);
Route::get('/eliminar_especialista', [EspecialistasController::class, 'eliminar_especialistas']);
Route::get('/get_single_especialista', [EspecialistasController::class, 'get_single_especialista']);
Route::get('/editar_especialista', [EspecialistasController::class, 'editar_especialista']);
//PROVEEDORES
Route::get('/proveedores', [ProveedoresController::class, 'get_proveedores']);
Route::get('/crear_proveedor', [ProveedoresController::class, 'create_proveedor']);
Route::get('/eliminar_proveedor', [ProveedoresController::class, 'delete_proveedor']);
Route::get('/get_single_proveedor', [ProveedoresController::class, 'get_single_proveedor']);
Route::get('/edit_proveedor', [ProveedoresController::class, 'edit_proveedor']);
//ADMINISTRATIVOS
Route::get('/administrativos', [AdministrativosController::class, 'get_administrativos']);
Route::get('/crear_administrativos', [AdministrativosController::class, 'create_administrativo']);
Route::get('/delete_administrativos', [AdministrativosController::class, 'delete_administrativo']);
Route::get('/edit_administrativo', [AdministrativosController::class, 'edit_administrativo']);
Route::get('/get_single_administrativo', [AdministrativosController::class, 'get_single_administrativo']);
//TRATAMIENTOS
Route::get('/tratamientos_main_page', [TratamientosController::class, 'get_tratamientos_main_page']);
Route::get('/tratamientos', [TratamientosController::class, 'get_tratamientos']);
Route::get('/crear_tratamientos', [TratamientosController::class, 'create_tratamiento']);
Route::get('/delete_tratamientos', [TratamientosController::class, 'delete_tratamiento']);
Route::get('/get_single_tratamiento', [TratamientosController::class, 'get_single_tratamiento']);
Route::get('/edit_tratamiento', [TratamientosController::class, 'edit_tratamiento']);
//PRODUCTOS
Route::get('/productos', [ProductoController::class, 'list_productos']);
Route::get('/create_productos', [ProductoController::class, 'create_producto']);
Route::get('/edit_producto', [ProductoController::class, 'edit_producto']);
Route::get('/delete_productos', [ProductoController::class, 'delete_producto']);
Route::get('/get_single_producto', [ProductoController::class, 'get_single_producto']);
Route::get('/asign_productos_proveedores', [ProductoController::class, 'asign_producto_proveedor']);
Route::get('/get_productos_asignados', [ProductoController::class, 'get_productos_asignados']);
Route::get('/find_producto_by_name', [ProductoController::class, 'find_producto_by_name']);
Route::get('/find_all_producto_by_name', [ProductoController::class, 'get_all_products_by_name']);
//PACIENTE
Route::get('/reg_paciente', [UserController::class, 'registrar_paciente']);
Route::get('/list_paciente', [UserController::class, 'list_pacientes']);
Route::get('/delete_paciente', [UserController::class, 'delete_paciente']);
Route::get('/get_pacientes_segun_especialista', [UserController::class, 'get_pacientes_segun_especialista']);
Route::get('/get_single_paciente', [UserController::class, 'get_single_paciente']);
Route::get('/edit_paciente', [UserController::class, 'edit_paciente']);
Route::get('/search_paciente', [UserController::class, 'search_paciente']);
//ORDENES PEDIDO
Route::get('/crear_orden_pedido', [OrdenPedidoController::class, 'crear_orden_pedido']);
Route::get('/list_ordenes_pedido', [OrdenPedidoController::class, 'list_ordenes_pedido']);
Route::get('/get_single_orden_pedido', [OrdenPedidoController::class, 'get_single_orden_pedido']);
Route::get('/editar_orden_pedido', [OrdenPedidoController::class, 'editar_orden_pedido']);
Route::get('/eliminar_orden_pedido', [OrdenPedidoController::class, 'eliminar_orden_pedido']);
Route::get('/get_orden_pedido_segun_especialista', [OrdenPedidoController::class, 'get_orden_pedido_segun_especialista']);
Route::get('/anular_solicitud', [OrdenPedidoController::class, 'anular_solicitud']);
Route::get('/change_estado', [OrdenPedidoController::class, 'change_estado']);
//TRATAMIENTOS AGENDADOS
Route::get('/listarTratamientosAgendados', [TratamientosAgendadosController::class, 'listarTratamientosAgendados']);
Route::get('/create_tratamiento_agendado', [TratamientosAgendadosController::class, 'create_tratamiento_agendado']);
Route::get('/list_tratamientos_paciente', [TratamientosAgendadosController::class, 'list_tratamientos_paciente']);
Route::get('/tratamientos_agendados_segun_especialista', [TratamientosAgendadosController::class, 'tratamientos_agendados_segun_especialista']);
Route::get('/anular_tratamiento_agendado', [TratamientosAgendadosController::class, 'anular_tratamiento_agendado']);
Route::get('/get_tratamiento_agendado_cita_agendada', [TratamientosAgendadosController::class, 'get_tratamiento_agendado_cita_agendada']);
//DIAGNOSTICOS
Route::get('/create_diagnostico', [DiagnosticoController::class, 'create_diagnostico']);
Route::get('/list_diagnosticos_paciente_especialista', [DiagnosticoController::class, 'list_diagnosticos_paciente_especialista']);
//BOLETA
Route::get('/emitir_boleta', [BoletasController::class, 'emitir_boleta']);
Route::get('/get_all_boletas', [BoletasController::class, 'get_all_boletas']);
//INFORMES
Route::get('/popular_odontologos', [InformesController::class, 'popular_odontologos']);
Route::get('/popular_tratamiento', [InformesController::class, 'popular_tratamiento']);
Route::get('/popular_producto', [InformesController::class, 'popular_producto']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/datos', function () {
  return DB::select('select * from paciente');
});
