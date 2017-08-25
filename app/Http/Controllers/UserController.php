<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function index()
    {
        $users = DB::table('users')->get();

        return view('user', ['users' => $users]);
    }

    public function getUserById($id)
    {
        $user = DB::table('users')->where('id', $id)->first();

     //   print_r($user); die;

        return view('user.profile', ['user' => $user]);
    }

    public function create(Request $request)
    {
        if( $request->method() == 'GET' )
        {
            return view('user.register');
        }
        //print_r($request->method()); die;
        print_r($request->input()); die;
    }


}