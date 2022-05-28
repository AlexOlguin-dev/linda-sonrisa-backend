<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
 
class CitaAgendadaController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function agendar_cita(Request $request)
    {
      $resp = 'ok';
      $fecha = $request->input('fecha');
      $hora = $request->input('hora');
      $rut_cliente = $request->input('rut_cliente');
      $rut_especialista = $request->input('rut_especialista');
      $data = ['FECHA' => $fecha, 'HORA' => $hora, 'RUT_PACIENTE' => $rut_cliente, 'RUT_ESPECIALISTA' => $rut_especialista];
      try {
        DB::table('citas_agendadas')->insert($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function get_taken_citas(Request $request)
    {
      $rut_especialista = $request->input('rut_especialista');
      $fecha = $request->input('fecha');
      $horas_tomadas = DB::table('citas_agendadas')
        ->where('rut_especialista','=',$rut_especialista)
        ->get();
      $horas_tomadas = json_decode($horas_tomadas, true);
      $horas = [];
      for ($i=0; $i < count($horas_tomadas); $i++) { 
        if ($horas_tomadas[$i]['fecha'] === $fecha.' 00:00:00') {
          array_push($horas,$horas_tomadas[$i]);
        }
      }
      return response()->json($horas);
    }

    public function get_citas_tomadas_segun_cliente(Request $request)
    {
      $rut_cliente = $request->input('rut_paciente');
      $horas_tomadas = DB::table('citas_agendadas')->where('rut_paciente','=',$rut_cliente)->get();
      //ARMA UN ARREGLO CON EL NOMBRE DEL ESPECIALISTA
      $horas_tomadas_data = [];
      $horas_tomadas = json_decode($horas_tomadas, true);
      for ($i=0; $i < count($horas_tomadas); $i++) { 
        $especialista = DB::table('especialista')->where('rut','=',$horas_tomadas[$i]['rut_especialista'])->get();
        array_push($horas_tomadas_data,[
          'id' => $horas_tomadas[$i]['id'],
          'fecha' => $horas_tomadas[$i]['fecha'],
          'hora' => $horas_tomadas[$i]['hora'],
          'rut_paciente' => $horas_tomadas[$i]['rut_paciente'],
          'rut_especialista' => $especialista[0]
        ]);
      }
      return response()->json($horas_tomadas_data);
    }

    public function delete_cita_agendada(Request $request)
    {
      $resp = 'ok';
      $id = $request->input('id');
      try {
        DB::table('citas_agendadas')->where('id','=',$id)->delete();
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function get_all_cita_agendada(){
      $cita_agendada = DB::table('citas_agendadas')->get();
      return response()->json($cita_agendada);
    }
}