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

    public function create_especialista(Request $request)
    {
      $resp = 'ok';
      $rut = $request->input('rut');
      $nombre_completo = $request->input('nombre_completo');
      $fecha_contratacion = $request->input('fecha_contratacion');
      $estado_contrato = $request->input('estado_contrato');
      $password = $request->input('pass');
      $data = ['rut' => $rut, 'nombre_completo' => $nombre_completo, 'fecha_contratacion' => $fecha_contratacion, 'estado_contrato' => $estado_contrato, 'password' => $password];
      try {
        DB::table('especialista')->insert($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function eliminar_especialistas(Request $request)
    {
      $resp = 'ok';
      $rut = $request->input('rut');
      try {
        DB::table('especialista')->where('rut','=',$rut)->delete();
      } catch (\Throwable $th) {
        $resp = 'ERROR';
        $citas_agendadas = DB::table('citas_agendadas')->where('rut_especialista','=',$rut)->get();
        $especialidad_especialista = DB::table('especialidades_especialista')->where('id_especialista','=',$rut)->get();
        if (count($citas_agendadas) !== 0 || count($especialidad_especialista) !== 0) {
          $resp = 'DATOS';
        }
      }
      return response()->json($resp);
    }

    public function full_eliminar_especialistas(Request $request)
    {
      $resp = 'ok';
      $rut = $request->input('rut');
      try {
        DB::table('citas_agendadas')->where('rut_especialista','=',$rut)->delete();
        DB::table('especialidades_especialista')->where('id_especialista','=',$rut)->delete();
        DB::table('especialista')->where('rut','=',$rut)->delete();
      } catch (\Throwable $th) {
        $resp = 'ERROR';
      }
      return response()->json($resp);
    }

    public function login(Request $request)
    {
      $username = $request->input('username');
      $pass = $request->input('password');
      $especialista = DB::table('especialista')->where([['rut','=',$username],['password','=',$pass]])->get();
      $resp = 'no_autorizado';
      if (count($especialista) !== 0) {
        $resp = "autorizado";
      }
      return response()->json([
        "user" => $especialista,
        "resp" => $resp
      ]);
    }
}