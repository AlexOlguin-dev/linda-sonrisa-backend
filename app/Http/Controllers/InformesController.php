<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
 
class InformesController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function popular_odontologos(){
      $especialistas = DB::table('especialista')->where('ESTADO','=','ACTIVO')->get();
      $especialistas = json_decode($especialistas, true);
      $populares = [];
      for ($i=0; $i < count($especialistas); $i++) {
        $citas_agendadas = DB::table('citas_agendadas')->where('rut_especialista','=',$especialistas[$i]['rut'])->get();
        $citas_agendadas = json_decode($citas_agendadas, true);
        array_push($populares,[
          "especialista" => $especialistas[$i]['nombre_completo'],
          "total_citas_agendadas" => count($citas_agendadas)
        ]);
      }
      return response()->json($populares);
    }

    public function popular_tratamiento(){
      $tratamientos = DB::table('tratamientos')->where('ESTADO','=','ACTIVO')->get();
      $tratamientos = json_decode($tratamientos, true);
      $populares = [];
      for ($i=0; $i < count($tratamientos); $i++) { 
        $tratamientos_agendado = DB::table('tratamiento_agendado')->where('id_tratamiento','=',$tratamientos[$i]['id'])->get();
        $tratamientos_agendado = json_decode($tratamientos_agendado, true);
        array_push($populares,[
          'tratamiento' => $tratamientos[$i]['nombre'],
          'total_tratamientos_agendados' => count($tratamientos_agendado)
        ]);
      }
      return response()->json($populares);
    }

    public function popular_producto(){
      $productos = DB::table('productos')->where('ESTADO','=','ACTIVO')->get();
      $productos = json_decode($productos, true);
      $populares = [];
      for ($i=0; $i < count($productos); $i++) { 
        $solicitud_insumo = DB::table('solicitud_insumos')->where('id_productos','=',$productos[$i]['id'])->get();
        $solicitud_insumo = json_decode($solicitud_insumo, true);
        array_push($populares,[
          'producto' => $productos[$i]['nombre'],
          'total_solicitudes' => count($solicitud_insumo)
        ]);
      }
      return response()->json($populares);
    }
}