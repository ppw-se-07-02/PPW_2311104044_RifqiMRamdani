<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', function () {
    return view('welcome');
});

/* ===== ROUTE TANPA PARAMETER ===== */
Route::get('/beranda', fn() => 'Halaman Beranda');
Route::get('/profil', fn() => 'Halaman Profil');
Route::get('/tentang', fn() => 'Halaman Tentang');
Route::get('/kontak', fn() => 'Halaman Kontak');
Route::get('/layanan', fn() => 'Halaman Layanan');

/* ===== ROUTE DENGAN PARAMETER ===== */
Route::get('/produk/{nama}', fn($nama) => "Produk: $nama");
Route::get('/kategori/{jenis}', fn($jenis) => "Kategori: $jenis");
Route::get('/user/{id}', fn($id) => "User ID: $id");

/* ===== ROUTE OPTIONAL PARAMETER ===== */
Route::get('/kendaraan/{jenis?}', fn($jenis = 'motor') =>
    "Jenis Kendaraan: $jenis"
);

Route::get('/kelas/{nama?}', fn($nama = 'TI-11') =>
    "Kelas: $nama"
);

Route::get('/buku/{judul?}/{penulis?}', function ($judul = 'Laravel', $penulis = 'Anonim') {
    return "Judul: $judul | Penulis: $penulis";
});

/* ===== CONTROLLER ===== */
Route::get('/data-mahasiswa', [PageController::class, 'mahasiswa']);

use App\Http\Controllers\NilaiController;

Route::get('/nilai', [NilaiController::class, 'index']);

Route::get('/tampilan', fn() => view('tampilan'));
