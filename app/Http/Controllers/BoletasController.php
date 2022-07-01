<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
 
class BoletasController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function emitir_boleta(Request $request)
    {
      $resp = 'ok';
      $id_cita_agendada = $request->input('id_cita_agendada');
      $total = $request->input('total_pago');
      $medio_pago = $request->input('medio_pago');
      $monto_pagado = $request->input('monto_pagado');
      $prevision = $request->input('prevision');
      $data = ['id_cita_agendada' => $id_cita_agendada, 'total_a_pagar' => $total, 'medio_de_pago' => $medio_pago, 'monto_pagado' => $monto_pagado, 'prevision' => $prevision];
      try {
        DB::table('boleta_cita')->insert($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function get_all_boletas()
    {
      $boleta = DB::table('boleta_cita')->get();
      $boleta = json_decode($boleta, true);
      $boleta_data = [];
      for ($i=0; $i < count($boleta); $i++) { 
        $cita_agendada = DB::table('citas_agendadas')->where('id','=',$boleta[$i]['id_cita_agendada'])->get();
        $cita_agendada = json_decode($cita_agendada, true);
        $paciente = DB::table('paciente')->where('rut','=',$cita_agendada[0]['rut_paciente'])->get();
        $paciente = json_decode($paciente, true);
        array_push($boleta_data,[
          "id_boleta" => $boleta[$i]['id_boleta'],
          "id_cita_agendada" => $boleta[$i]['id_cita_agendada'],
          "fecha" => date("d-m-Y", strtotime($cita_agendada[0]['fecha'])).' '.$cita_agendada[0]['hora'],
          "total_a_pagar" => $boleta[$i]['total_a_pagar'],
          "medio_de_pago" => $boleta[$i]['medio_de_pago'],
          "monto_pagado" => $boleta[$i]['monto_pagado'],
          "prevision" => $boleta[$i]['prevision'],
          "paciente_rut" => $paciente[0]['rut'],
          "paciente_nombre" => $paciente[0]['nombres'].' '.$paciente[0]['apellidos'],
        ]);
      }
      return response()->json($boleta_data);
    }
}