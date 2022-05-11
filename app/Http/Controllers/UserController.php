<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
 
class UserController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function login(Request $request)
    {
      $rut = $request->input('rut');
      $pass = $request->input('password');
      $pacientes = DB::table('paciente')->where([['rut','=',$rut],['password','=',$pass]])->get();
      $resp = 'no_autorizado';
      if (count($pacientes) !== 0) {
        $resp = 'autorizado';
      }
      return response()->json([
        "user" => $pacientes,
        "resp" => $resp
      ]);
    }
}