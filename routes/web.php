<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Back\AdminBanner_Controller;
use App\Http\Controllers\Back\AdminDashboard_Controller;
use App\Http\Controllers\Back\AdminKategori_Controller;
use App\Http\Controllers\Back\AdminProduk_Controller;
use App\Http\Controllers\Back\AdminSlider_Controller;
use App\Http\Controllers\Front\BerandaController;
use App\Http\Controllers\Front\KeranjangController;
use App\Http\Controllers\Front\PembayaranController;
use App\Http\Controllers\Front\ProdukController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [BerandaController::class, 'halaman_beranda'])->name('HalamanBeranda');
Route::get('detail-produk/{slug}', [ProdukController::class, 'halaman_detail_produk'])->name('HalamanDetailProduk');
Route::post('/response-produk-variasi', [ProdukController::class, 'resp_produk_variasi']);


Route::middleware(['guest'])->group(function () {
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'halaman_register')->name('Register');
        Route::get('/kota/{provinsi_id}', 'list_kota');
        Route::post('/user-register', 'user_register')->name('UserRegister');
    });

    Route::controller(LoginController::class)->group(function (){
        Route::get('/login', 'halaman_login')->name('Login');
        Route::post('/user-login', 'autentikasi')->name('UserLogin');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user-logout', [LoginController::class, 'logout'])->name('UserLogout');


    Route::prefix('admin')->name('admin.')->middleware(['isAdmin'])->group(function () {

        Route::controller(AdminDashboard_Controller::class)->group(function (){
            Route::get('/dashboard', 'dashboard')->name('HalamanDashboard');
        });

        Route::controller(AdminKategori_Controller::class)->group(function (){
            Route::get('/kategori', 'kategori')->name('HalamanKategori');
            Route::any('/data-kategori', 'data_kategori')->name('DataKategori');
            Route::post('/tambah-data-kategori', 'tambah_data_kategori')->name('TambahDataKategori');
            Route::post('/edit-data-kategori', 'edit_data_kategori')->name('EditDataKategori');
            Route::get('/hapus-data-kategori/{kategori_id}', 'hapus_data_kategori');
        });

        Route::controller(AdminProduk_Controller::class)->group(function (){
            Route::get('/produk', 'produk')->name('HalamanProduk');
            Route::get('/produk-detail/{slug}', 'produk_detail')->name('HalamanProduk.HalamanProdukDetail');
            Route::any('/data-produk', 'data_produk')->name('DataProduk');
            Route::post('/tambah-data-produk', 'tambah_data_produk')->name('TambahDataProduk');
            Route::get('/edit-data-produk/{id}', 'edit_data_produk')->name('HalamanProduk.HalamanEditDataProduk');
            Route::post('/ubah-data-produk', 'ubah_data_produk')->name('UbahDataProduk');
            Route::get('/hapus-data-produk/{produk_id}', 'hapus_data_produk');

            Route::get('/hapus-data-produk-variasi/{produk_variasi_id}', 'hapus_data_produk_variasi');
            Route::post('/tambah-data-produk-variasi/{produk_id}', 'tambah_data_produk_variasi')->name('TambahDataProdukVariasi');
            Route::post('/update-data-produk-variasi', 'update_data_produk_variasi')->name('UpdateDataProdukVariasi');

            Route::post('/tambah-data-gambar-produk/{produk_id}', 'tambah_data_gambar_produk')->name('TambahDataGambarProduk');
            Route::get('/hapus-data-gambar-produk/{gambar_produk_id}', 'hapus_data_gambar_produk');
        });

        Route::controller(AdminBanner_Controller::class)->group(function (){
            Route::get('/banner', 'banner')->name('HalamanBanner');
            Route::any('/data-banner', 'data_banner')->name('DataBanner');
            Route::post('/tambah-data-banner', 'tambah_data_banner')->name('TambahDataBanner');
            Route::post('/edit-data-banner', 'edit_data_banner')->name('EditDataBanner');
            Route::get('/hapus-data-banner/{banner_id}', 'hapus_data_banner');
        });

        Route::controller(AdminSlider_Controller::class)->group(function (){
            Route::get('/slider', 'slider')->name('HalamanSlider');
            Route::any('/data-slider', 'data_slider')->name('DataSlider');
            Route::post('/tambah-data-slider', 'tambah_data_slider')->name('TambahDataSlider');
            Route::post('/edit-data-slider', 'edit_data_slider')->name('EditDataSlider');
            Route::get('/hapus-data-slider/{slider_id}', 'hapus_data_slider');
        });

    });

    Route::prefix('customer')->name('customer.')->middleware(['isCustomer'])->group(function () {
        Route::post('/tambah-ke-keranjang', [ProdukController::class, 'tambah_ke_keranjang'])->name('TambahKeKeranjang');

        Route::controller(KeranjangController::class)->group(function (){
            Route::get('/keranjang', 'keranjang')->name('HalamanKeranjang');
            Route::post('/update-kuantitas-produk-keranjang', 'update_kuantitas_produk_keranjang');
            Route::get('/hapus-produk-dalam-keranjang', 'hapus_produk_dalam_keranjang');
        });

        Route::controller(PembayaranController::class)->group(function (){
            Route::get('/pembayaran', 'pembayaran')->name('HalamanPembayaran');
            Route::post('/cek-ongkir', 'cek_ongkir');
        });
    });


});
