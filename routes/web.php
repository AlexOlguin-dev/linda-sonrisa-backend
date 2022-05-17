<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Controllers\EspecialistasController;

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

//LOGIN
Route::get('/login', [UserController::class, 'login']);
//COMBOBOX INICIALES DASHBOARD CLIENTE
Route::get('/especialidades', [EspecialidadesController::class, 'list_especialidades']);
Route::get('/especialistas', [EspecialistasController::class, 'list_especialistas']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/datos', function () {
  return DB::select('select * from paciente');
});
