<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
 
class TratamientosController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function get_tratamientos()
    {
      $tratamientos = DB::table('tratamientos')->where('ESTADO','=','ACTIVO')->get();
      return response()->json($tratamientos);
    }

    public function get_tratamientos_main_page()
    {
      $tratamientos = DB::table('tratamientos')->where('ESTADO','=','ACTIVO')->get();
      $tratamientos = json_decode($tratamientos, true);
      $vals = [];
      if (count($tratamientos) <= 3) {
        for ($i=0; $i < count($tratamientos); $i++) { 
          array_push($vals,$tratamientos[$i]);
        }
      }else{
        for ($i=0; $i < 4; $i++) {
          array_push($vals,[
            "id" => $tratamientos[$i]['id'],
            "nombre" => $tratamientos[$i]['nombre'],
            "precio" => $tratamientos[$i]['precio'],
            "descripcion" => $tratamientos[$i]['descripcion'],
            "estado" => $tratamientos[$i]['estado'],
            "index" => $i
          ]);
        }
      }
      return response()->json($vals);
    }

    public function create_tratamiento(Request $request)
    {
      $resp = 'ok';
      $nombre = $request->input('nombre');
      $precio = $request->input('precio');
      $descripcion = $request->input('descripcion');
      $data = ['nombre' => $nombre, 'precio' => $precio, 'descripcion' => $descripcion, 'estado' => 'ACTIVO', 'IMAGEN' => 'default.jpg'];
      try {
        DB::table('tratamientos')->insert($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function delete_tratamiento(Request $request)
    {
      $resp = 'ok';
      $id_tratamiento = $request->input('id');
      $data = ['ESTADO' => 'ELIMINADO'];
      try {
        //DB::table('tratamientos')->where('id','=',$id_tratamiento)->delete();
        DB::table('tratamientos')->where('id','=',$id_tratamiento)->update($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }

    public function get_single_tratamiento(Request $request)
    {
      $id = $request->input('id');
      $tratamientos = DB::table('tratamientos')->where('id','=',$id)->get();
      return response()->json($tratamientos);
    }

    public function edit_tratamiento(Request $request)
    {
      $resp = 'ok';
      $id = $request->input('id');
      $nombre = $request->input('nombre');
      $precio = $request->input('precio');
      $descripcion = $request->input('descripcion');
      $data = ['nombre' => $nombre, 'precio' => $precio, 'descripcion' => $descripcion];
      try {
        DB::table('tratamientos')->where('id','=',$id)->update($data);
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }
}