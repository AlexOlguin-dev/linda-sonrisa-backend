<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
 
class AdminController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function login(Request $request)
    {
      $username = $request->input('username');
      $pass = $request->input('password');
      $admin = DB::table('administrador')->where([['username','=',$username],['password','=',$pass]])->get();
      $resp = 'no_autorizado';
      if (count($admin) !== 0) {
        $resp = "autorizado";
      }
      return response()->json([
        "user" => $admin,
        "resp" => $resp
      ]);
    }
}