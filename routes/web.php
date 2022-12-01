<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\CobaLoginController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index']);
/*
Route::get('/user', 'UserController@index');
Route::get('/user-register', 'UserController@create');
Route::post('/user-register', 'UserController@store');
Route::get('/user-edit/{id}', 'UserController@edit');
*/
Route::resource('user', UserController::class);
Route::get('/search', [UserController::class, 'search'])->name('search');

Route::resource('anggota', AnggotaController::class);

Route::resource('buku', BukuController::class);
Route::get('/format_buku', [BukuController::class, 'format']);
Route::post('/import_buku', [BukuController::class, 'import']);

Route::resource('transaksi', TransaksiController::class);
Route::get('/laporan/trs', [LaporanController::class, 'transaksi']);
Route::get('/laporan/trs/pdf', [LaporanController::class, 'transaksiPdf']);
Route::get('/laporan/trs/excel', [LaporanController::class, 'transaksiExcel']);

Route::get('/laporan/buku', [LaporanController::class, 'buku']);
Route::get('/laporan/buku/pdf', [LaporanController::class, 'bukuPdf']);
Route::get('/laporan/buku/excel', [LaporanController::class, 'bukuExcel']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/coba-login', [CobaLoginController::class, 'login'])->name('cobaLogin');
Route::get('/coba-login', [CobaLoginController::class, 'index'])->name('indexLogin');
