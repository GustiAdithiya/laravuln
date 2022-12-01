<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CobaLoginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        // $user = User::where('username', $request->username)->where('password', md5($request->password))->first();
        $user = DB::select(DB::raw("select * from users where username = '".$request->username."' and password = '".md5($request->password)."'"));
        if ($user) {
            return view('welcome');
        }

        return back()->withErrors([
            'password' => 'Wrong username or password',
        ]);
    }
}
