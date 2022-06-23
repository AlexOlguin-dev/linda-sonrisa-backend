<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
 
class ProveedoresController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function get_proveedores()
    {
      $proveedores = DB::table('proveedor')->where('ESTADO','=','ACTIVO')->get();
      return response()->json($proveedores);
    }

    public function create_proveedor(Request $request)
    {
      $resp = 'ok';
      $rut = $request->input('rut');
      $nombre = $request->input('nombre');
      $telefono = $request->input('telefono');
      $mail = $request->input('mail');
      $direccion = $request->input('direccion');
      $data = ['rut' => $rut, 'nombre' => $nombre, 'telefono' => $telefono, 'mail' => $mail, 'direccion' => $direccion, 'ESTADO' => 'ACTIVO'];
      try {
        DB::table('proveedor')->insert($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function delete_proveedor(Request $request)
    {
      $resp = 'ok';
      $rut = $request->input('rut');
      $data = ['ESTADO' => 'ELIMINADO'];
      try {
        DB::table('proveedor')->where('rut','=',$rut)->update($data);
        //DB::table('proveedor')->where('rut','=',$rut)->delete();
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function get_single_proveedor(Request $request)
    {
      $rut = $request->input('rut');
      $proveedor = DB::table('proveedor')->where('rut','=',$rut)->get();
      return response()->json($proveedor);
    }
    
    public function edit_proveedor(Request $request)
    {
      $resp = 'ok';
      $rut = $request->input('rut');
      $nombre = $request->input('nombre');
      $telefono = $request->input('telefono');
      $mail = $request->input('mail');
      $direccion = $request->input('direccion');
      $data = ['NOMBRE' => $nombre, 'TELEFONO' => $telefono, 'MAIL' => $mail, 'DIRECCION' => $direccion];
      try {
        DB::table('proveedor')->where('rut','=',$rut)->update($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }
}