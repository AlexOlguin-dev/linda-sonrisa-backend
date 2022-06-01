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
      $citas_agendadas = DB::table('citas_agendadas')->where('rut_especialista','=',$rut_especialista)->get();
      $citas_agendadas = json_decode($citas_agendadas, true);
      $pacientes = [];
      //OBTIENE RUTS PACIENTE
      for ($i=0; $i < count($citas_agendadas); $i++) { 
        array_push($pacientes,$citas_agendadas[$i]['rut_paciente']);
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