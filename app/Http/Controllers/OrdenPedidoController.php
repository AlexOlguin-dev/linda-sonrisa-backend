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
      $ordenes_pedido = json_decode($ordenes_pedido, true);
      $solicitudes = [];
      for ($i=0; $i < count($ordenes_pedido); $i++) { 
        $productos = DB::table('productos')->where('id','=',$ordenes_pedido[$i]['id_productos'])->get();
        $productos = json_decode($productos, true);
        $especialista = DB::table('especialista')->where('rut','=',$ordenes_pedido[$i]['rut_especialista'])->get();
        $especialista = json_decode($especialista, true);
        array_push($solicitudes,[
          "id_solicitud" => $ordenes_pedido[$i]['id_solicitud'],
          "cant" => $ordenes_pedido[$i]['cant'],
          "estado_solicitud" => $ordenes_pedido[$i]['estado_solicitud'],
          "id_productos" => $ordenes_pedido[$i]['id_productos'],
          "nombre_producto" => $productos[0]['nombre'],
          "rut_especialista" => $ordenes_pedido[$i]['rut_especialista'],
          "nombre_especialista" => $especialista[0]['nombre_completo']
        ]);
      }
      return response()->json($solicitudes);
    }

    public function crear_orden_pedido(Request $request)
    {
      $resp = 'ok';
      $cant = $request->input('cant');
      $id_producto = $request->input('id_productos');
      $rut_especialista = $request->input('rut_especialista');
      $data = ['cant' => $cant, 'estado_solicitud' => 'PENDIENTE', 'id_productos' => $id_producto, 'rut_especialista' => $rut_especialista];
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

    public function get_orden_pedido_segun_especialista(Request $request)
    {
      $rut_especialista = $request->input('rut_especialista');
      $solicitudes_insumos = DB::table('solicitud_insumos')->where('rut_especialista','=',$rut_especialista)->get();
      $solicitudes_insumos = json_decode($solicitudes_insumos, true);
      $solicitud = [];
      for ($i=0; $i < count($solicitudes_insumos); $i++) { 
        $producto = DB::table('productos')->where('id','=',$solicitudes_insumos[$i]['id_productos'])->get();
        $producto = json_decode($producto, true);
        array_push($solicitud, [
          "id_solicitud" => $solicitudes_insumos[$i]['id_solicitud'],
          "cant" => $solicitudes_insumos[$i]['cant'],
          "estado_solicitud" => $solicitudes_insumos[$i]['estado_solicitud'],
          "id_productos" => $producto[0]['nombre'],
        ]);
      }
      return response()->json($solicitud);
    }

    public function anular_solicitud(Request $request)
    {
      $resp = 'ok';
      $id = $request->input('id');
      $data = ['ESTADO_SOLICITUD' => 'ANULADO'];
      try {
        DB::table('solicitud_insumos')->where('id_solicitud','=',$id)->update($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }
}