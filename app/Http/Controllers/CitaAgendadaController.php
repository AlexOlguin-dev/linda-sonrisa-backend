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
      $data = ['FECHA' => $fecha, 'HORA' => $hora, 'RUT_PACIENTE' => $rut_cliente, 'RUT_ESPECIALISTA' => $rut_especialista, 'ESTADO' => 'PENDIENTE'];
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
      $horas_tomadas = DB::table('citas_agendadas')->where('rut_especialista','=',$rut_especialista)->get();
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
      $horas_tomadas = DB::table('citas_agendadas')->where([['rut_paciente','=',$rut_cliente],['ESTADO','=','PENDIENTE']])->get();
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
      $data = ['ESTADO' => 'ANULADA'];
      try {
        //DB::table('citas_agendadas')->where('id','=',$id)->delete();
        DB::table('citas_agendadas')->where('id','=',$id)->update($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function get_all_cita_agendada(){
      $citas_agendadas = DB::table('citas_agendadas')->get();
      $citas_agendadas = json_decode($citas_agendadas, true);
      $citas = [];
      for ($i=0; $i < count($citas_agendadas); $i++) { 
        $paciente = DB::table('paciente')->where('rut','=',$citas_agendadas[$i]['rut_paciente'])->get();
        $paciente = json_decode($paciente, true);
        $especialista = DB::table('especialista')->where('rut','=',$citas_agendadas[$i]['rut_especialista'])->get();
        $especialista = json_decode($especialista, true);
        array_push($citas, [
          "id" => $citas_agendadas[$i]['id'],
          "fecha" => date("d-m-Y", strtotime($citas_agendadas[$i]['fecha'])),
          "hora" => $citas_agendadas[$i]['hora'],
          "rut_paciente" => $citas_agendadas[$i]['rut_paciente'],
          "nombre_paciente" => $paciente[0]['nombres'].' '.$paciente[0]['apellidos'],
          "rut_especialista" => $citas_agendadas[$i]['rut_especialista'],
          "nombre_especialista" => $especialista[0]['nombre_completo'],
          "estado" => $citas_agendadas[$i]['estado']
        ]);
      }
      return response()->json($citas);
    }

    public function list_citas_agendadas_especialista(Request $request)
    {
      //$rut_especialista = $request->input('rut_especialista');
      //$citas_agendadas = DB::table('citas_agendadas')->where('rut_especialista','=',$rut_especialista)->get();
      //return response()->json($citas_agendadas);
      $rut_especialista = $request->input('rut_especialista');
      $citas_agendadas = DB::table('citas_agendadas')->where([['rut_especialista','=',$rut_especialista],['ESTADO','=','PENDIENTE']])->get();
      $citas_agendadas = json_decode($citas_agendadas,true);
      $citas = [];
      for ($i=0; $i < count($citas_agendadas); $i++) { 
        $paciente = DB::table('paciente')->where('rut','=',$citas_agendadas[$i]['rut_paciente'])->get();
        $paciente = json_decode($paciente, true);
        array_push($citas,[
          "id" => $citas_agendadas[$i]['id'],
          "fecha" => date("d-m-Y", strtotime($citas_agendadas[$i]['fecha'])),
          "hora" => $citas_agendadas[$i]['hora'],
          "rut_paciente" => $citas_agendadas[$i]['rut_paciente'],
          "nombre_paciente" => $paciente[0]['nombres'].' '.$paciente[0]['apellidos'],
          "rut_especialista" => $citas_agendadas[$i]['rut_especialista'],
          "estado" => $citas_agendadas[$i]['estado']
        ]);
      }
      return response()->json($citas);
    }

    public function search_cita_agendada(Request $request)
    {
      /*$rut = $request->input('rut');
      $rut_especialista = $request->input('rut_especialista');
      $citas_agendadas = DB::table('citas_agendadas')->where([['rut_paciente','LIKE','%'.$rut.'%'],['rut_especialista','=',$rut_especialista]])->get();
      return response()->json($citas_agendadas);*/
      $rut = $request->input('rut');
      $rut_especialista = $request->input('rut_especialista');
      $citas_agendadas = DB::table('citas_agendadas')->where([['rut_paciente','LIKE','%'.$rut.'%'],['rut_especialista','=',$rut_especialista],['ESTADO','=','PENDIENTE']])->get();
      $citas_agendadas = json_decode($citas_agendadas,true);
      $citas = [];
      for ($i=0; $i < count($citas_agendadas); $i++) { 
        $paciente = DB::table('paciente')->where('rut','=',$citas_agendadas[$i]['rut_paciente'])->get();
        $paciente = json_decode($paciente, true);
        array_push($citas,[
          "id" => $citas_agendadas[$i]['id'],
          "fecha" => date("d-m-Y", strtotime($citas_agendadas[$i]['fecha'])),
          "hora" => $citas_agendadas[$i]['hora'],
          "rut_paciente" => $citas_agendadas[$i]['rut_paciente'],
          "nombre_paciente" => $paciente[0]['nombres'].' '.$paciente[0]['apellidos'],
          "rut_especialista" => $citas_agendadas[$i]['rut_especialista'],
          "estado" => $citas_agendadas[$i]['estado']
        ]);
      }
      return response()->json($citas);
    }
}