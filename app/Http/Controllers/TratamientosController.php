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
      $tratamientos = DB::table('tratamientos')->get();
      return response()->json($tratamientos);
    }

    public function get_tratamientos_main_page()
    {
      $tratamientos = DB::table('tratamientos')->get();
      $vals = [];
      if (count($tratamientos) <= 3) {
        for ($i=0; $i < count($tratamientos); $i++) { 
          array_push($vals,$tratamientos[$i]);
        }
      }else{
        for ($i=0; $i < 4; $i++) {
          array_push($vals,$tratamientos[$i]);
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
      $data = ['nombre' => $nombre, 'precio' => $precio, 'descripcion' => $descripcion];
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
      try {
        DB::table('tratamientos')->where('id','=',$id_tratamiento)->delete();
      } catch (\Throwable $th) {
        $resp = 'not_ok';
      }
      return response()->json($resp);
    }
}