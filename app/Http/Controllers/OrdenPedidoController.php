<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
 
class OrdenPedidoController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function list_ordenes_pedido()
    {
      $ordenes_pedido = DB::table('solicitud_insumos')->get();
      return response()->json($ordenes_pedido);
    }

    public function crear_orden_pedido(Request $request)
    {
      $resp = 'ok';
      $cant = $request->input('cant');
      $id_producto = $request->input('id_productos');
      $id_tratamiento_agendado = $request->input('id_tratamiento_agendado');
      $data = ['cant' => $cant, 'estado_solicitud' => 'PENDIENTE', 'id_productos' => $id_producto, 'id_tratamiento_agendado' => $id_tratamiento_agendado];
      try {
        DB::table('solicitud_insumos')->insert($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function get_single_orden_pedido(Request $request)
    {
      $id = $request->input('id');
      $orden_pedido = DB::table('solicitud_insumos')->where('id_solicitud','=',$id)->get();
      return response()->json($orden_pedido);
    }

    public function editar_orden_pedido(Request $request)
    {
      $resp = 'ok';
      $id_solicitud = $request->input('id');
      $cant = $request->input('cant');
      $estado = $request->input('estado');
      $data = ['cant' => $cant, 'estado_solicitud' => $estado];
      try {
        DB::table('solicitud_insumos')->where('id_solicitud','=',$id_solicitud)->update($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function eliminar_orden_pedido(Request $request)
    {
      $resp = 'ok';
      $id_solicitud = $request->input('id');
      try {
        DB::table('solicitud_insumos')->where('id_solicitud','=',$id_solicitud)->delete();
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }
}