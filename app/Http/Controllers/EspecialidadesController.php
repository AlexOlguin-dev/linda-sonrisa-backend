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

    public function create_especialidad_especialista(Request $request)
    {
      $resp = 'ok';
      $rut_especialista = $request->input('rut');
      $id_especialidad = $request->input('especialidad');
      $data = ['id_especialista' => $rut_especialista, 'id_especialidad' => $id_especialidad];
      try {
        DB::table('especialidades_especialista')->insert($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function get_especialidades_especialista(Request $request)
    {
      $rut = $request->input('rut');
      $especialidades = DB::table('especialidades_especialista')->where('id_especialista','=',$rut)->get();
      $especialidades = json_decode($especialidades, true);
      $especialidades_id = [];
      for ($i=0; $i < count($especialidades); $i++) {
        $especialidad = DB::table('especialidades')->where('id','=',$especialidades[$i]['id_especialidad'])->get();
        array_push($especialidades_id,$especialidad[0]);
      }
      return response()->json($especialidades_id);
    }

    public function delete_especialidad_especialista(Request $request)
    {
      $resp = 'ok';
      $rut_especialista = $request->input('rut');
      $id_especialidad = $request->input('especialidad');
      try {
        DB::table('especialidades_especialista')->where([['id_especialista','=',$rut_especialista],['id_especialidad','=',$id_especialidad]])->delete();
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }
}