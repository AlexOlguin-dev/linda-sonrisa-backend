<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
 
class UserController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function login(Request $request)
    {
      $rut = $request->input('rut');
      $pass = $request->input('password');
      $pacientes = DB::table('paciente')->where([['rut','=',$rut],['password','=',$pass]])->get();
      $resp = 'no_autorizado';
      if (count($pacientes) !== 0) {
        $resp = 'autorizado';
      }
      return response()->json([
        "user" => $pacientes,
        "resp" => $resp
      ]);
    }

    public function registrar_paciente(Request $request)
    {
      $resp = 'ok';
      $rut = $request->input('rut');
      $password = $request->input('password');
      $mail = $request->input('mail');
      $telefono = $request->input('telefono');
      $nombres = $request->input('nombres');
      $apellidos = $request->input('apellidos');
      $estado = "ACTIVO";
      $data = ['rut'=>$rut,'password'=>$password,'mail'=>$mail,'telefono'=>$telefono,'nombres'=>$nombres,'apellidos'=>$apellidos, 'estado' => $estado];
      try {
        DB::table('PACIENTE')->insert($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function list_pacientes()
    {
      $clientes = DB::table('paciente')->where('ESTADO','=','ACTIVO')->get();
      return response()->json($clientes);
    }

    public function delete_paciente(Request $request)
    {
      $resp = 'ok';
      $rut = $request->input('rut');
      $data = ['ESTADO' => 'INACTIVO'];
      try {
        DB::table('paciente')->where('rut','=',$rut)->update($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function get_pacientes_segun_especialista(Request $request)
    {
      $rut_especialista = $request->input('rut_especialista');
      $citas_agendadas = DB::table('citas_agendadas')->where([['rut_especialista','=',$rut_especialista],['ESTADO','=','PENDIENTE']])->get();
      $citas_agendadas = json_decode($citas_agendadas, true);
      $pacientes = [];
      //OBTIENE RUTS PACIENTE
      for ($i=0; $i < count($citas_agendadas); $i++) {
        $paciente = DB::table('paciente')->where('rut','=',$citas_agendadas[$i]['rut_paciente'])->get();
        $paciente = json_decode($paciente, true);
        array_push($pacientes,[
          'rut_paciente' => $citas_agendadas[$i]['rut_paciente'],
          'nombre_paciente' => $paciente[0]['nombres'].' '.$paciente[0]['apellidos']
        ]);
      }
      //LIMPIA RUTS PACIENTE
      $result = [];
      foreach ($pacientes as $key => $value){
        if(!in_array($value, $result))
          array_push($result,$value);
      }
      return response()->json($result);
    }

    public function get_single_paciente(Request $request)
    {
      $rut_paciente = $request->input('rut');
      $paciente = DB::table('paciente')->where('rut','=',$rut_paciente)->get();
      return response()->json($paciente);
    }

    public function edit_paciente(Request $request)
    {
      $resp = 'ok';
      $rut = $request->input('rut');
      $nombres = $request->input('nombres');
      $apellidos = $request->input('apellidos');
      $correo = $request->input('correo');
      $telefono = $request->input('telefono');
      $data = ['rut' => $rut, 'mail' => $correo, 'telefono' => $telefono, 'nombres' => $nombres, 'apellidos' => $apellidos];
      try {
        DB::table('paciente')->where('rut','=',$rut)->update($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function search_paciente(Request $request)
    {
      $rut = $request->input('rut');
      $rut_especialista = $request->input('rut_especialista');
      $citas_agendadas = DB::table('citas_agendadas')->where([['rut_paciente','LIKE','%'.$rut.'%'],['ESTADO','=','PENDIENTE'],['rut_especialista','=',$rut_especialista]])->get();
      $citas_agendadas = json_decode($citas_agendadas, true);
      $pacientes = [];
      //OBTIENE RUTS PACIENTE
      for ($i=0; $i < count($citas_agendadas); $i++) { 
        $paciente = DB::table('paciente')->where('rut','=',$citas_agendadas[$i]['rut_paciente'])->get();
        $paciente = json_decode($paciente, true);
        array_push($pacientes,[
          'rut_paciente' => $citas_agendadas[$i]['rut_paciente'],
          'nombre_paciente' => $paciente[0]['nombres'].' '.$paciente[0]['apellidos']
        ]);
      }
      //LIMPIA RUTS PACIENTE
      $result = [];
      foreach ($pacientes as $key => $value){
        if(!in_array($value, $result))
          array_push($result,$value);
      }
      return response()->json($result);
    }
}