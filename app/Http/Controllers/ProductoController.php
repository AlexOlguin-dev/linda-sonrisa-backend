<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
 
class ProductoController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function list_productos()
    {
      $productos = DB::table('productos')->where('ESTADO','=','ACTIVO')->get();
      return response()->json($productos);
    }

    public function create_producto(Request $request)
    {
      $resp = 'ok';
      $nombre = $request->input('nombre');
      $stock = $request->input('stock');
      $costo = $request->input('costo');
      $data = ['nombre' => $nombre, 'stock' => $stock, 'costo' => $costo, 'ESTADO' => 'ACTIVO'];
      try {
        DB::table('productos')->insert($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function delete_producto(Request $request)
    {
      $resp = 'ok';
      $id = $request->input('id');
      $data = ['ESTADO' => 'ELIMINADO'];
      try {
        DB::table('productos')->where('id','=',$id)->update($data);
        //DB::table('productos')->where('id','=',$id)->delete();
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function edit_producto(Request $request)
    {
      $resp = 'ok';
      $id = $request->input('id');
      $nombre = $request->input('nombre');
      $stock = $request->input('stock');
      $costo = $request->input('costo');
      $data = ['nombre' => $nombre, 'stock' => $stock, 'costo' => $costo];
      try {
        DB::table('productos')->where('id','=',$id)->update($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function get_single_producto(Request $request)
    {
      $id = $request->input('id');
      $producto = DB::table('productos')->where('id','=',$id)->get();
      return response()->json($producto);
    }

    public function asign_producto_proveedor(Request $request)
    {
      $resp = 'ok';
      $id_producto = $request->input('id_producto');
      $rut_proveedor = $request->input('rut_proveedor');
      $data = ['rut_proveedor' => $rut_proveedor];
      try {
        DB::table('productos')->where('id','=',$id_producto)->update($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp); 
    }

    public function get_productos_asignados(Request $request)
    {
      $rut_proveedor = $request->input('rut_proveedor');
      $productos = DB::table('productos')->where('rut_proveedor','=',$rut_proveedor)->get();
      return response()->json($productos);
    }

    public function find_producto_by_name(Request $request)
    {
      $nombre = $request->input('nombre');
      $productos = DB::table('productos')->where('nombre','LIKE','%'.$nombre.'%')->get();
      $productos= json_decode($productos, true);
      $found_products = [];
      for ($i=0; $i < count($productos); $i++) { 
        if ($productos[$i]['rut_proveedor'] === null) {
          array_push($found_products,$productos[$i]);
        }
      }
      return response()->json($found_products);
    }

    public function get_all_products_by_name(Request $request)
    {
      $nombre = $request->input('nombre');
      $productos = DB::table('productos')->where('nombre','LIKE','%'.$nombre.'%')->get();
      return response()->json($productos);
    }
}