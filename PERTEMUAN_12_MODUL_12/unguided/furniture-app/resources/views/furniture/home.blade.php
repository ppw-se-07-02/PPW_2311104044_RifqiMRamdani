@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="text-center mb-5">
    <h1 class="display-5 fw-bold">Selamat Datang di A Mitra Furniture</h1>
    <p class="lead">Aplikasi jual beli furniture terlengkap dan terbaik di Indonesia</p>
</div>

<div class="row">
    <!-- Produk 1: Kursi Goyang -->
    <div class="col-md-3 col-6 mb-4">
        <div class="product-card text-center">
            <div class="product-image mb-3" style="height: 200px; overflow: hidden; border-radius: 8px;">
                <img src="{{ asset('images/dan1.jpg') }}" 
                     class="img-fluid w-100 h-100" 
                     alt="Kursi Goyang"
                     style="object-fit: cover;"
                     onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200/ACD2FF/000?text=Kursi+Goyang';">
            </div>
            <h4 class="fw-bold">Kursi Goyang</h4>
            <p class="text-primary fw-bold fs-5">Rp 1.450.000</p>
            <button class="btn btn-furniture w-100">
                <i class="fas fa-cart-plus"></i> + Keranjang
            </button>
        </div>
    </div>
    
    <!-- Produk 2: Sofa Modern -->
    <div class="col-md-3 col-6 mb-4">
        <div class="product-card text-center">
            <div class="product-image mb-3" style="height: 200px; overflow: hidden; border-radius: 8px;">
                <img src="{{ asset('images/dan2.jpg') }}" 
                     class="img-fluid w-100 h-100" 
                     alt="Sofa Modern"
                     style="object-fit: cover;"
                     onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200/ACD2FF/000?text=Sofa+Modern';">
            </div>
            <h4 class="fw-bold">Sofa Modern</h4>
            <p class="text-primary fw-bold fs-5">Rp 2.950.000</p>
            <button class="btn btn-furniture w-100">
                <i class="fas fa-cart-plus"></i> + Keranjang
            </button>
        </div>
    </div>
    
    <!-- Produk 3: Meja Kayu Jati -->
    <div class="col-md-3 col-6 mb-4">
        <div class="product-card text-center">
            <div class="product-image mb-3" style="height: 200px; overflow: hidden; border-radius: 8px;">
                <img src="{{ asset('images/dan3.jpg') }}" 
                     class="img-fluid w-100 h-100" 
                     alt="Meja Kayu Jati"
                     style="object-fit: cover;"
                     onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200/ACD2FF/000?text=Meja+Kayu+Jati';">
            </div>
            <h4 class="fw-bold">Meja Kayu Jati</h4>
            <p class="text-primary fw-bold fs-5">Rp 1.350.000</p>
            <button class="btn btn-furniture w-100">
                <i class="fas fa-cart-plus"></i> + Keranjang
            </button>
        </div>
    </div>
    
    <!-- Produk 4: Ranjang Minimalis -->
    <div class="col-md-3 col-6 mb-4">
        <div class="product-card text-center">
            <div class="product-image mb-3" style="height: 200px; overflow: hidden; border-radius: 8px;">
                <img src="{{ asset('images/dan4.jpg') }}" 
                     class="img-fluid w-100 h-100" 
                     alt="Ranjang Minimalis"
                     style="object-fit: cover;"
                     onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200/ACD2FF/000?text=Ranjang+Minimalis';">
            </div>
            <h4 class="fw-bold">Ranjang Minimalis</h4>
            <p class="text-primary fw-bold fs-5">Rp 3.950.000</p>
            <button class="btn btn-furniture w-100">
                <i class="fas fa-cart-plus"></i> + Keranjang
            </button>
        </div>
    </div>
</div>

<!-- Status Database -->
<div class="row mt-5">
    <div class="col-12">
        <div class="product-card">
            <h3 class="text-center mb-4"><i class="fas fa-database"></i> Status Database</h3>
            <div class="alert alert-success">
                <h4 class="alert-heading"><i class="fas fa-check-circle"></i> Migration Berhasil!</h4>
                <p>Database sudah dibuat dengan 4 tabel sesuai Tugas Modul 12:</p>
                <ul class="mb-0">
                    <li><strong>users</strong> - Tabel pengguna</li>
                    <li><strong>products</strong> - Tabel produk furniture</li>
                    <li><strong>carts</strong> - Tabel keranjang belanja</li>
                    <li><strong>orders</strong> - Tabel pesanan</li>
                </ul>
                <hr>
                <p class="mb-0">
                    <strong>Tugas 12.1 ✅</strong> - 4 File Migration sudah dibuat<br>
                    <strong>Tugas 12.2 ✅</strong> - 3 Metode Database sudah diimplementasi
                </p>
            </div>
            
            <div class="text-center mt-3">
                <a href="/test-raw-sql" class="btn btn-outline-primary me-2">Test Raw SQL</a>
                <a href="/test-query-builder" class="btn btn-outline-primary me-2">Test Query Builder</a>
                <a href="/test-eloquent" class="btn btn-outline-primary">Test Eloquent ORM</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Animasi untuk tombol keranjang
    document.querySelectorAll('.btn-furniture').forEach(button => {
        button.addEventListener('click', function() {
            const productName = this.closest('.product-card').querySelector('h4').textContent;
            alert(productName + ' ditambahkan ke keranjang!');
        });
    });
</script>
@endsection