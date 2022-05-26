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
}