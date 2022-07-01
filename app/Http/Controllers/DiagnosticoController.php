<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
 
class DiagnosticoController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function create_diagnostico(Request $request)
    {
      $resp = 'ok';
      $id_cita = $request->input('id_cita');
      $descripcion = $request->input('descripcion');
      $data = ['id_cita' => $id_cita, 'descripcion' => $descripcion];
      try {
        DB::table('diagnostico')->insert($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function list_diagnosticos_paciente_especialista(Request $request)
    {
      $rut_paciente = $request->input('rut_paciente');
      $citas_agendadas = DB::table('citas_agendadas')->where('rut_paciente','=',$rut_paciente)->get();
      $citas_agendadas = json_decode($citas_agendadas, true);
      $diagnosticos = [];
      for ($i=0; $i < count($citas_agendadas); $i++) {
        $found_diag = DB::table('diagnostico')->where('id_cita','=',$citas_agendadas[$i]['id'])->get();
        $found_diag = json_decode($found_diag, true);
        if (count($found_diag) !== 0) {
          //array_push($diagnosticos,$found_diag[0]);
          $especialista = DB::table('especialista')->where('rut','=',$citas_agendadas[$i]['rut_especialista'])->get();
          $especialista = json_decode($especialista, true);
          array_push($diagnosticos,[
            "id_diagnostico" => $found_diag[0]['id_diagnostico'],
            "fecha_cita_agendada" => date("d-m-Y", strtotime($citas_agendadas[$i]['fecha'])),
            "hora_cita_agendada" => $citas_agendadas[$i]['hora'],
            "especialista" => $especialista[0]['nombre_completo'],
            "descripcion" => $found_diag[0]['descripcion']
          ]);
        }
      }
      return response()->json($diagnosticos);
    }
}