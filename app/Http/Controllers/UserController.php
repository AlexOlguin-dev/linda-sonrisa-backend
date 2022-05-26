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
      $data = ['rut'=>$rut,'password'=>$password,'mail'=>$mail,'telefono'=>$telefono,'nombres'=>$nombres,'apellidos'=>$apellidos];
      try {
        DB::table('PACIENTE')->insert($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function list_pacientes()
    {
      $clientes = DB::table('paciente')->get();
      return response()->json($clientes);
    }

    public function delete_paciente(Request $request)
    {
      $resp = 'ok';
      $rut = $request->input('rut');
      try {
        DB::table('paciente')->where('rut','=',$rut)->delete();
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }
}