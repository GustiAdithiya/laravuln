<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function search(Request $request)
    {
        // hilangkan komentar untuk menambahkan htmlspecialchars
        //$keyword = htmlspecialchars($request->search);
        $keyword = $request->search;
        //HILANGKAN KOMEN LINE 30 DAN UNTUK SEARCH YANG BENAR
        $datas = User::where('name', 'like', "%" . $keyword . "%")->paginate(5);
        
        //KOMENTAR LINE 33 UNTUK SEARCH YANG SALAH
        // $datas = $keyword;
        return view('auth.user', compact('datas','keyword'));
    }

    public function index()
    {
        if(Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }
        $keyword = "";

        $datas = User::get();
        return view('auth.user', compact('datas','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = User::where('username',$request->input('username'))->count();

        if($count>0){
            Session::flash('message', 'Already exist!');
            Session::flash('message_type', 'danger');
            return redirect()->to('user');
        }

        // UNCOMMENT CODE DIBAWAH UNTUK MENGGUNAKAN VALIDASI YANG BENAR
        // COMMENT CODE VALIDASI YANG SALAH
        /* -- VALIDASI INPUT YANG BENAR -- */
        // $this->validate($request, [
        //     'name' => 'required|string|max:255',
        //     'username' => 'required|string|max:20|unique:users',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8|confirmed',
        /*      atau lebih ketat lagi
                'password' => [
                        'required',
                        Password::min(8)
                            ->letters()
                            ->mixedCase()
                            ->numbers()
                            ->symbols()
                            ->uncompromised()
                    ],
                    'password_confirmation' => 'required|same:password'
        */
        //     'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
        /* ------------------------------ */
        
        // UNCOMMENT CODE DIBAWAH UNTUK MENGGUNAKAN VALIDASI YANG SALAH
        // COMMENT CODE VALIDASI YANG BENAR
        /* -- VALIDASI INPUT YANG SALAH -- */
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'gambar' => 'required',
        ]);
        /* -------------------------------- */


        if($request->file('gambar') == '') {
            $gambar = NULL;
        } else {
            $file = $request->file('gambar');
            $getTime = Carbon::now();
            $getExtension  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999).'-'.$getTime->format('Y-m-d-H-i-s').'.'.$getExtension; 
            $request->file('gambar')->move("images/user", $fileName);
            $gambar = $fileName;
        }

        User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'level' => $request->input('level'),

            /* PENGGUNAAN HASH BCRYPT */
            //  'password' => bcrypt(($request->input('password'))),
            /* ---------------------- */

            /* PENGGUNAAN HASH MD5 */
            'password' => md5(($request->input('password'))),
            /* ------------------- */

            /* TIDAK MENGGUNAKAN HASH */
            //'password' => $request->input('password'),
            /* ---------------------- */
            'gambar' => $gambar
        ]);

        

        Session::flash('message', 'Berhasil ditambahkan!');
        Session::flash('message_type', 'success');
        return redirect()->route('user.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $data = User::findOrFail($id);

        return view('auth.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   

        $data = User::findOrFail($id);

        return view('auth.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_data = User::findOrFail($id);

        if($request->file('gambar')) 
        {
            $file = $request->file('gambar');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak; 
            $request->file('gambar')->move("images/user", $fileName);
            $user_data->gambar = $fileName;
        }

        $user_data->name = $request->input('name');
        //HILANGKAN KOMENTAR UNTUK PENYIMPANAN FIELD USERNAME DAN EMAIL
        // $user_data->username = $request->input('username');
        // $user_data->email = $request->input('email');
        if($request->input('password')) {
        $user_data->level = $request->input('level');
        }

        if($request->input('password')) {
            $user_data->password= bcrypt(($request->input('password')));
        
        }

        $user_data->update();

        Session::flash('message', 'Berhasil diubah!');
        Session::flash('message_type', 'success');
        return redirect()->to('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->id != $id) {
            // query menggunakan bawaan framework
            // $user_data = User::findOrFail($id);
            // $user_data->delete();

            // delete data dengan menggunakan query sql
            DB::delete('delete from users where id = ' . $id);
            Session::flash('message', 'Berhasil dihapus!');
            Session::flash('message_type', 'success'); 
        } else {
            Session::flash('message', 'Akun anda sendiri tidak bisa dihapus!');
            Session::flash('message_type', 'danger');
        }

        
        return redirect()->to('user');
    }
}
