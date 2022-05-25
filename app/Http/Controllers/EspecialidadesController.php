<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
 
class EspecialidadesController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function list_especialidades()
    {
      $especialidades = DB::table('especialidades')->get();
      return response()->json($especialidades);
    }

    public function get_name_especialidad(Request $request)
    {
      $id_especialidad = $request->input('id_especialidad');
      $especialidades = DB::table('especialidades')->where('id','=',$id_especialidad)->get();
      return response()->json($especialidades);
    }
}