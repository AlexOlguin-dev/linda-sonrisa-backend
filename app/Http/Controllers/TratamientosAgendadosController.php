<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
 
class TratamientosAgendadosController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function listarTratamientosAgendados(Request $request)
    {
      $tratamientos_agendados = DB::table('tratamiento_agendado')->get();
      return response()->json($tratamientos_agendados);
    }
}