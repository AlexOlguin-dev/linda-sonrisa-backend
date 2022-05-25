<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
 
class EspecialistasController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function list_especialistas()
    {
      $especialitas = DB::table('especialista')->get();
      return response()->json($especialitas);
    }

    public function list_especialistas_segun_especialidad(Request $request)
    {
      $id_especialidad = $request->input('id_especialidad');
      $especialitas = DB::table('especialidades_especialista')
        ->where('id_especialidad','=',$id_especialidad)
        ->get();
      $especialistas_json = json_decode($especialitas, true);
      $especialistas_data = [];
      for ($i=0; $i < count($especialitas); $i++) {
        $esp_data = DB::table('especialista')->where('rut','=',$especialistas_json[$i]['id_especialista'])->get();
        array_push($especialistas_data,$esp_data[0]);
      }
      return response()->json($especialistas_data);
    }

    public function get_name_especialista(Request $request)
    {
      $rut = $request->input('rut');
      $especialitas = DB::table('especialista')->where('rut','=',$rut)->get();
      return response()->json($especialitas[0]);
    }
}