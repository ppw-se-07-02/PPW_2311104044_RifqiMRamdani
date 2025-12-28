@extends('layouts.app')

@section('title', 'Keranjang')
@section('content')
<h2 class="mb-4">Keranjang Belanja</h2>

<div class="row">
    <div class="col-md-8">
        <div class="product-card">
            <h5><i class="fas fa-shopping-cart"></i> Item dalam Keranjang</h5>
            <hr>
            <div class="d-flex align-items-center mb-3">
                <img src="https://via.placeholder.com/80x80/ACD2FF/000?text=Kursi" 
                     class="rounded me-3" alt="Produk">
                <div class="flex-grow-1">
                    <h6 class="mb-1">Kursi Goyang</h6>
                    <p class="text-primary fw-bold mb-1">Rp 1.450.000</p>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-secondary">-</button>
                        <span class="mx-2">1</span>
                        <button class="btn btn-sm btn-outline-secondary">+</button>
                        <button class="btn btn-sm btn-danger ms-3">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="product-card">
            <h5>Ringkasan Belanja</h5>
            <hr>
            <div class="d-flex justify-content-between mb-2">
                <span>Subtotal</span>
                <span>Rp 1.450.000</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span>Total</span>
                <span class="fw-bold text-primary">Rp 1.450.000</span>
            </div>
            <button class="btn btn-furniture w-100">Checkout</button>
        </div>
    </div>
</div>
@endsection