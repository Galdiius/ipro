<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\PengepulController;
use App\Http\Controllers\ProyekController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\UsersController;

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

Route::prefix('/')->middleware(['isLogin'])->group(function(){
    Route::get('', [HomeController::class,'index']);
    Route::get('proyek', [ProyekController::class,'index'])->middleware('proyekOnly');
    Route::get('proyek/profile/{id}', [ProyekController::class,'profile'])->middleware('proyekOnly');
    Route::delete('proyek/delete/{id}', [ProyekController::class,'delete'])->middleware('proyekOnly');
    Route::get('proyek/edit/{id}', [ProyekController::class,'edit'])->middleware('proyekOnly');
    Route::post('proyek/edit', [ProyekController::class,'_edit'])->middleware('proyekOnly');
    Route::get('profile',[HomeController::class,'profile']);
    Route::get('editProfile/{id}',[HomeController::class,'editProfile']);
    Route::post('editProfile',[HomeController::class,'_editProfile']);
    Route::post('editProfilePengepul',[HomeController::class,'editProfilePengepul']);
    Route::get('unduhQrcode/{token}/{nama}',[VerifyController::class,'getQrCode']);
    Route::get('tambahProyek',[ProyekController::class,'tambah'])->middleware('proyekOnly');
    Route::post('tambahProyek',[ProyekController::class,'_tambah'])->middleware('proyekOnly');
    Route::get('sendVerifikasi/{via}/{table}/{id}',[VerifyController::class,'sendVerifikasi']);
    Route::get('kirimMaterial',[MaterialController::class,'index'])->middleware(['pengepulOnly']);
    Route::post('/terkirim',[MaterialController::class,'terkirim']);
    Route::get('riwayat',[PengirimanController::class,'riwayat']);
    Route::post('/konfirmasi',[PengirimanController::class,'konfirmasi']);
    Route::get('peningkatan',[ProyekController::class,'peningkatan']);
    Route::post('peningkatan',[ProyekController::class,'_peningkatan']);
    Route::get('users',[UsersController::class,'index']);
});

Route::prefix('/pengiriman')->middleware(['isLogin'])->group(function(){
    Route::get('',[PengirimanController::class,'index']);
    Route::get('print/{id}',[PengirimanController::class,'print']);
});


Route::prefix('/pengepul')->middleware(['isLogin','mitraProyekOnly'])->group(function(){
    Route::get('',[PengepulController::class,'index']);
    Route::get('tambah',[PengepulController::class,'tambah']);
    Route::post('tambah',[PengepulController::class,'_tambah']);
    Route::delete('hapus',[PengepulController::class,'hapus']);
    Route::get('profile/{id}',[PengepulController::class,'profile']);
    Route::get('edit/{id}',[PengepulController::class,'edit']);
    Route::post('edit',[PengepulController::class,'_edit']);
});

Route::prefix('kategori')->middleware(['isLogin','mitraProyekOnly'])->group(function(){
    // Route::get('',[KategoriController::class,'index']);
    Route::post('tambah',[KategoriController::class,'tambah']);
    Route::delete('hapus',[KategoriController::class,'hapus']);
    Route::post('edit',[KategoriController::class,'edit']);
});
Route::prefix('jenis')->middleware(['isLogin','mitraProyekOnly'])->group(function(){
    Route::get('',[JenisController::class,'index']);
    Route::post('tambah',[JenisController::class,'tambah']);
    Route::delete('hapus',[JenisController::class,'hapus']);
    Route::post('edit',[JenisController::class,'edit']);
});
Route::prefix('barang')->middleware(['isLogin','mitraProyekOnly'])->group(function(){
    Route::get('',[BarangController::class,'index']);
    Route::post('tambah',[BarangController::class,'tambah']);
    Route::delete('hapus',[BarangController::class,'hapus']);
    Route::post('edit',[BarangController::class,'edit']);
});

Route::post('logout',[AuthController::class,'logout']);
Route::prefix('login')->middleware(['login'])->group(function(){
    Route::get('',[AuthController::class,'admin']);
    Route::post('',[AuthController::class,'_admin']);
});

Route::prefix('/mitra')->middleware(['proyekOnly'])->group(function(){
    Route::get('',[MitraController::class,'index']);
    Route::get('tambah',[MitraController::class,'tambah']);
    Route::post('tambah',[MitraController::class,'_tambah']);
    Route::get('profile/{id}',[MitraController::class,'profile']);
    Route::delete('hapus',[MitraController::class,'hapus']);
    Route::get('edit/{id}',[MitraController::class,'edit']);
    Route::post('edit',[MitraController::class,'_edit']);
});

Route::get('/verifikasi/{token}',[VerifyController::class,'index']);
Route::post('/verifikasi/{token}',[VerifyController::class,'_verify']);

Route::post('/material/submit',[MaterialController::class,'submit']);
