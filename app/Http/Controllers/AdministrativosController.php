<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
 
class AdministrativosController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function get_administrativos()
    {
      $administrativos = DB::table('administrativos')->get();
      return response()->json($administrativos);
    }

    public function create_administrativo(Request $request)
    {
      $resp = 'ok';
      $rut = $request->input('rut');
      $password = $request->input('pass');
      $nombre_completo = $request->input('nombre_completo');
      $cargo = $request->input('cargo');
      $fecha_contratacion = $request->input('fecha_contratacion');
      $estado_contrato = $request->input('estado_contrato');
      $data = ['rut' => $rut, 'password' => $password, 'nombre_completo' => $nombre_completo, 'cargo' => $cargo, 'fecha_contratacion' => $fecha_contratacion, 'estado_contrato' => $estado_contrato];
      try {
        DB::table('administrativos')->insert($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function delete_administrativo(Request $request)
    {
      $resp = 'ok';
      $rut = $request->input('rut');
      try {
        DB::table('administrativos')->where('rut','=',$rut)->delete();
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function edit_administrativo(Request $request)
    {
      $resp = 'ok';
      $rut = $request->input('rut');
      $nombre_completo = $request->input('nombre_completo');
      $cargo = $request->input('cargo');
      $fecha_contratacion = $request->input('fecha_contratacion');
      $estado_contrato = $request->input('estado_contrato');
      $data = ['nombre_completo' => $nombre_completo, 'cargo' => $cargo, 'fecha_contratacion' => $fecha_contratacion, 'estado_contrato' => $estado_contrato];
      try {
        DB::table('administrativos')->where('rut','=',$rut)->update($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function get_single_administrativo(Request $request)
    {
      $rut = $request->input('rut');
      $administrativo = DB::table('administrativos')->where('rut','=',$rut)->get();
      return response()->json($administrativo);
    }

    public function login(Request $request)
    {
      $username = $request->input('username');
      $pass = $request->input('pass');
      $administrativo = DB::table('administrativos')->where([['rut','=',$username],['password','=',$pass]])->get();
      $resp = 'no_autorizado';
      if (count($administrativo) !== 0) {
        $resp = 'autorizado';
      }
      return response()->json([
        "user" => $administrativo,
        "resp" => $resp
      ]);
    }
}