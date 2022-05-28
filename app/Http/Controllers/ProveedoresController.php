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
      $proveedores = DB::table('proveedor')->get();
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
      $data = ['rut' => $rut, 'nombre' => $nombre, 'telefono' => $telefono, 'mail' => $mail, 'direccion' => $direccion];
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
      try {
        DB::table('proveedor')->where('rut','=',$rut)->delete();
      } catch (\Throwable $th) {
        $resp = 'not_ok';
        $productos = DB::table('productos')->where('rut_proveedor','=',$rut)->get();
        if (count($productos) !== 0) {
          $resp = 'DATOS';
        }
      }
      return response()->json($resp);
    }

    public function full_delete_proveedor(Request $request)
    {
      $resp = 'ok';
      $rut = $request->input('rut');
      $data = ['rut_proveedor' => ''];
      try {
        DB::table('productos')->where('rut_proveedor','=',$rut)->update($data);
        DB::table('proveedor')->where('rut','=',$rut)->delete();
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }
}