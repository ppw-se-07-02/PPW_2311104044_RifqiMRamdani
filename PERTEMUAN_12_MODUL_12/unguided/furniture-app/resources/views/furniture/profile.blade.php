@extends('layouts.app')

@section('title', 'Profil')
@section('content')
<h2 class="mb-4">Profil Pengguna</h2>

<div class="row">
    <div class="col-md-4">
        <div class="product-card text-center">
            <img src="https://via.placeholder.com/100x100/ACD2FF/000?text=User" 
                 class="rounded-circle mb-3" alt="Profil">
            <h5>Nama Pengguna</h5>
            <p>pelanggan@email.com</p>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="product-card">
            <h5>Informasi Akun</h5>
            <hr>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" value="Pelanggan Furniture">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" value="pelanggan@email.com">
            </div>
            <div class="mb-3">
                <label class="form-label">No. Telepon</label>
                <input type="text" class="form-control" value="08123456789">
            </div>
            <button class="btn btn-furniture">Simpan Perubahan</button>
        </div>
    </div>
</div>

<div class="mt-4">
    <div class="product-card">
        <h5>Riwayat Pesanan</h5>
        <hr>
        <p class="text-muted">Belum ada riwayat pesanan.</p>
    </div>
</div>
@endsection