<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        // $result = DB::select(DB::raw("select * from users where username = '".$request->username."' and password = '".$request->password."'"));
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
        // if ($result != null) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'password' => 'Wrong username or password',
        ]);
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required',
    //         'password' => 'required',
    //     ]);
    //     $user = User::where('username', $request->username)->where('password', md5($request->password))->first();
    //     // $result = DB::select(DB::raw("select * from users where username = '".$request->username."' and password = '".md5($request->password)."'"));
    //     if ($user) {
    //         Auth::login($user);
    //         return redirect()->intended('/');
    //     }

    //     return back()->withErrors([
    //         'password' => 'Wrong username or password',
    //     ]);
    // }
}
