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

    public function create_tratamiento_agendado(Request $request)
    {
      $resp = 'ok';
      $id_tratamiento = $request->input('id_tratamiento');
      $id_cita = $request->input('id_cita');
      $data = ['id_tratamiento' => $id_tratamiento, 'id_cita_agendada' => $id_cita, 'ESTADO' => 'ACTIVO'];
      try {
        DB::table('tratamiento_agendado')->insert($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function list_tratamientos_paciente(Request $request)
    {
      $rut_paciente = $request->input('rut_paciente');
      $citas_agendadas = DB::table('citas_agendadas')->where('rut_paciente','=',$rut_paciente)->get();
      $citas_agendadas = json_decode($citas_agendadas, true);
      $tratamientos = [];
      for ($i=0; $i < count($citas_agendadas); $i++) { 
        $found_tratamientos = DB::table('tratamiento_agendado')->where([['id_cita_agendada','=',$citas_agendadas[$i]['id']],['ESTADO','=','ACTIVO']])->get();
        $found_tratamientos = json_decode($found_tratamientos, true);
        if (count($found_tratamientos) !== 0) {
          $data_tratamiento = DB::table('tratamientos')->where('id','=',$found_tratamientos[0]['id_tratamiento'])->get();
          $data_tratamiento = json_decode($data_tratamiento, true);
          $especialista = DB::table('especialista')->where('rut','=',$citas_agendadas[$i]['rut_especialista'])->get();
          $especialista = json_decode($especialista, true);
          //array_push($tratamientos,$found_tratamientos[0]);
          array_push($tratamientos,[
            "id" => $found_tratamientos[0]['id'],
            "id_tratamiento" => $found_tratamientos[0]['id_tratamiento'],
            "nombre_tratamiento" => $data_tratamiento[0]['nombre'],
            "id_cita_agendada" => $found_tratamientos[0]['id_cita_agendada'],
            "fecha_cita_agendada" => date("d-m-Y", strtotime($citas_agendadas[$i]['fecha'])),
            "hora_cita_agendada" => $citas_agendadas[$i]['hora'],
            "especialista" => $especialista[0]['nombre_completo'],
            "estado" => $found_tratamientos[0]['estado']
          ]);
        }
      }
      return response()->json($tratamientos);
    }

    public function tratamientos_agendados_segun_especialista(Request $request)
    {
      $rut_especialista = $request->input('rut_especialista');
      $citas_agendadas = DB::table('citas_agendadas')->where([['rut_especialista','=',$rut_especialista],['ESTADO','=','PENDIENTE']])->get();
      $citas_agendadas = json_decode($citas_agendadas, true);
      $tratamientos = [];
      for ($i=0; $i < count($citas_agendadas); $i++) {
        $tratamiento = DB::table('tratamiento_agendado')->where([['id_cita_agendada','=',$citas_agendadas[$i]['id']],['ESTADO','=','ACTIVO']])->get();
        if (count($tratamiento) !== 0) {
          array_push($tratamientos,$tratamiento);
        }
      }
      return response()->json($tratamientos[0]);
    }

    public function anular_tratamiento_agendado(Request $request)
    {
      $resp = 'ok';
      $id = $request->input('id');
      $data = ['ESTADO' => 'ANULADO'];
      try {
        DB::table('tratamiento_agendado')->where('id','=',$id)->update($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }
}