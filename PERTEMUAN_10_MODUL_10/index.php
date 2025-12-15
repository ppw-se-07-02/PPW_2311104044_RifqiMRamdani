<?php
include "koneksi.php";

// Ambil data produk untuk ditampilkan
$query = "SELECT * FROM produk ORDER BY created_at DESC LIMIT 6";
$result_produk = mysqli_query($conn, $query);

// Hitung total produk
$query_total = "SELECT COUNT(*) as total FROM produk";
$result_total = mysqli_query($conn, $query_total);
$total_produk = mysqli_fetch_assoc($result_total)['total'];

// Ambil kategori unik untuk filter
$query_kategori = "SELECT DISTINCT kategori FROM produk WHERE kategori IS NOT NULL";
$result_kategori = mysqli_query($conn, $query_kategori);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Batik Nusantara</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        /* Additional inline styles */
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('uploads/OIP.webp');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
            position: relative;
        }
        
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(to bottom right, transparent 49%, white 50%);
        }
        
        .product-card {
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .card-img-top {
            height: 250px;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .product-card:hover .card-img-top {
            transform: scale(1.05);
        }
        
        .category-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
            padding: 8px 15px;
            font-weight: 600;
        }
        
        .price-tag {
            font-size: 1.3rem;
            font-weight: bold;
            color: #dc3545;
        }
        
        .stock-badge {
            font-size: 0.8rem;
            padding: 5px 10px;
        }
        
        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, #0d6efd, #6f42c1);
        }
        
        .feature-card {
            text-align: center;
            padding: 30px 20px;
            border-radius: 15px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            font-size: 3rem;
            color: #0d6efd;
            margin-bottom: 20px;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .testimonial-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
        }
        
        .newsletter-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
            border-radius: 20px;
        }
        
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: #0d6efd;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            opacity: 0;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .back-to-top.show {
            opacity: 1;
        }
        
        .back-to-top:hover {
            background: #0b5ed7;
            transform: translateY(-3px);
        }
        
        /* Animation for cards */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-card {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0;
            }
            
            .hero-section h1 {
                font-size: 2rem;
            }
            
            .card-img-top {
                height: 200px;
            }
        }
    </style>
</head>
<body>
    <!-- Back to Top Button -->
    <a href="#" class="back-to-top">
        <i class="bi bi-arrow-up"></i>
    </a>
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
                <i class="bi bi-shop-window fs-3 me-2"></i>
                <span>Batik Nusantara</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class="bi bi-house me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#produk">
                            <i class="bi bi-grid me-1"></i> Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">
                            <i class="bi bi-info-circle me-1"></i> Tentang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">
                            <i class="bi bi-telephone me-1"></i> Kontak
                        </a>
                    </li>
                    <?php if(isAdminLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-warning text-dark mx-2" href="admin/dashboard.php">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light text-primary" href="login.php">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login Admin
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container position-relative">
            <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown">Batik Warisan Nusantara</h1>
            <p class="lead mb-4 animate__animated animate__fadeInUp animate__delay-1s">
                Koleksi batik terbaik dengan kualitas premium dan harga terjangkau
            </p>
            <div class="animate__animated animate__fadeIn animate__delay-2s">
                <a href="#produk" class="btn btn-primary btn-lg px-4 me-2">
                    <i class="bi bi-eye me-1"></i> Lihat Produk
                </a>
                <a href="#tentang" class="btn btn-outline-light btn-lg px-4">
                    <i class="bi bi-info-circle me-1"></i> Tentang Kami
                </a>
            </div>
            
            <!-- Features -->
            <div class="row mt-5 pt-4">
                <div class="col-md-4">
                    <div class="feature-card animate-card" style="animation-delay: 0.1s">
                        <div class="feature-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h5>Gratis Ongkir</h5>
                        <p class="text-muted">Gratis pengiriman untuk order di atas Rp 300.000</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate-card" style="animation-delay: 0.2s">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h5>Garansi 100%</h5>
                        <p class="text-muted">Garansi uang kembali jika tidak sesuai</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate-card" style="animation-delay: 0.3s">
                        <div class="feature-icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h5>Support 24/7</h5>
                        <p class="text-muted">Customer service siap membantu Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Produk Section -->
    <section id="produk" class="py-5">
        <div class="container">
            <h2 class="section-title fw-bold text-primary">Produk Terbaru</h2>
            <p class="text-center text-muted mb-4">Temukan koleksi batik terbaik kami</p>
            
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary fs-6 p-2 me-3">
                            <i class="bi bi-box me-1"></i> Total <?= $total_produk ?> Produk
                        </span>
                        
                        <?php if(mysqli_num_rows($result_kategori) > 0): ?>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary active" data-filter="all">Semua</button>
                            <?php while($kategori = mysqli_fetch_assoc($result_kategori)): ?>
                            <button type="button" class="btn btn-outline-primary" data-filter="<?= $kategori['kategori'] ?>">
                                <?= $kategori['kategori'] ?>
                            </button>
                            <?php endwhile; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <a href="login.php" class="btn btn-primary">
                        <i class="bi bi-arrow-right-circle me-1"></i> Lihat Semua
                    </a>
                </div>
            </div>

            <div class="row g-4" id="productContainer">
                <?php if(mysqli_num_rows($result_produk) > 0): ?>
                    <?php 
                    $delay = 0;
                    while($produk = mysqli_fetch_assoc($result_produk)): 
                        $delay += 0.1;
                    ?>
                    <div class="col-md-4 col-lg-3" data-category="<?= $produk['kategori'] ?>">
                        <div class="card product-card animate-card" style="animation-delay: <?= $delay ?>s">
                            <div class="position-relative">
                                <span class="category-badge badge bg-primary"><?= $produk['kategori'] ?></span>
                                <img src="uploads/<?= $produk['gambar'] ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($produk['nama']) ?>"
                                     loading="lazy">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($produk['nama']) ?></h5>
                                <p class="card-text text-muted small flex-grow-1">
                                    <?= substr(htmlspecialchars($produk['deskripsi']), 0, 60) ?>...
                                </p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="price-tag">
                                            Rp <?= number_format($produk['harga'], 0, ',', '.') ?>
                                        </span>
                                        <span class="stock-badge badge 
                                            <?= $produk['stok'] > 10 ? 'bg-success' : 
                                              ($produk['stok'] > 0 ? 'bg-warning' : 'bg-danger') ?>">
                                            <?= $produk['stok'] > 0 ? "Stok: {$produk['stok']}" : 'Habis' ?>
                                        </span>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary btn-add-to-cart" 
                                                data-id="<?= $produk['id'] ?>"
                                                data-name="<?= htmlspecialchars($produk['nama']) ?>"
                                                data-price="<?= $produk['harga'] ?>"
                                                <?= $produk['stok'] == 0 ? 'disabled' : '' ?>>
                                            <i class="bi bi-cart me-1"></i> 
                                            <?= $produk['stok'] > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' ?>
                                        </button>
                                        <button class="btn btn-outline-primary btn-quick-view" 
                                                data-id="<?= $produk['id'] ?>">
                                            <i class="bi bi-eye me-1"></i> Quick View
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center py-5">
                            <i class="bi bi-info-circle display-4 text-primary"></i>
                            <h4 class="mt-3">Belum ada produk</h4>
                            <p class="text-muted">Silakan login sebagai admin untuk menambahkan produk</p>
                            <a href="login.php" class="btn btn-primary mt-2">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login Admin
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Quick View Modal -->
            <div class="modal fade" id="quickViewModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" id="quickViewContent">
                            <!-- Content will be loaded via AJAX -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Section -->
    <section id="tentang" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title fw-bold text-primary">Tentang Toko Batik Nusantara</h2>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="position-relative">
                        <img src="uploads/banner2.jpg" class="img-fluid rounded shadow" alt="Tentang Kami" loading="lazy">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-success fs-6 p-2">Berkualitas</span>
                        </div>
                        <div class="position-absolute bottom-0 end-0 m-3">
                            <span class="badge bg-warning fs-6 p-2">Terpercaya</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3 class="mb-3 text-primary">Menjual Batik Berkualitas Sejak 2025</h3>
                    <p class="lead">
                        Kami adalah toko batik online yang menyediakan berbagai macam produk batik berkualitas 
                        dengan harga terjangkau. Mulai dari hijab batik, pakaian pria dan wanita, hingga aksesoris batik.
                    </p>
                    <p>
                        Dengan pengalaman bertahun-tahun dalam industri batik, kami berkomitmen untuk menyediakan 
                        produk terbaik yang memadukan tradisi dan modernitas.
                    </p>
                    
                    <div class="row mt-4">
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle p-3 me-3">
                                    <i class="bi bi-box text-white fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 text-primary"><?= $total_produk ?>+</h4>
                                    <p class="text-muted mb-0">Produk Tersedia</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle p-3 me-3">
                                    <i class="bi bi-tags text-white fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 text-success">4+</h4>
                                    <p class="text-muted mb-0">Kategori Produk</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning rounded-circle p-3 me-3">
                                    <i class="bi bi-truck text-white fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 text-warning">50+</h4>
                                    <p class="text-muted mb-0">Pengiriman/Bulan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-info rounded-circle p-3 me-3">
                                    <i class="bi bi-people text-white fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 text-info">100+</h4>
                                    <p class="text-muted mb-0">Pelanggan Puas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title fw-bold text-primary">Testimonial Pelanggan</h2>
            <p class="text-center text-muted mb-5">Apa kata mereka tentang produk kami</p>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="text-center">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" 
                                 class="testimonial-img" 
                                 alt="Testimonial 1">
                            <h5 class="mb-2">Sarah Wijaya</h5>
                            <div class="text-warning mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                        <p class="text-muted">
                            "Kualitas batiknya sangat bagus, bahan nyaman dipakai. Pengiriman juga cepat. Recommended!"
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="text-center">
                            <img src="https://randomuser.me/api/portraits/men/54.jpg" 
                                 class="testimonial-img" 
                                 alt="Testimonial 2">
                            <h5 class="mb-2">Budi Santoso</h5>
                            <div class="text-warning mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                        </div>
                        <p class="text-muted">
                            "Saya beli kemeja batik untuk acara kantor. Motifnya elegan dan bahannya sejuk. Puas banget!"
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="text-center">
                            <img src="https://randomuser.me/api/portraits/women/67.jpg" 
                                 class="testimonial-img" 
                                 alt="Testimonial 3">
                            <h5 class="mb-2">Dewi Lestari</h5>
                            <div class="text-warning mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                        <p class="text-muted">
                            "Hijab batiknya cantik sekali, motifnya unik dan bahan premium. Pasti beli lagi!"
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-5">
        <div class="container">
            <div class="newsletter-section text-center">
                <h2 class="fw-bold mb-3">Dapatkan Info Promo Terbaru</h2>
                <p class="mb-4">Daftar newsletter kami untuk mendapatkan diskon dan info produk baru</p>
                <form id="newsletterForm" class="row g-3 justify-content-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Email Anda" required>
                            <button class="btn btn-light" type="submit">
                                <i class="bi bi-envelope me-1"></i> Daftar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3 d-flex align-items-center">
                        <i class="bi bi-shop-window fs-4 me-2"></i> Batik Nusantara
                    </h5>
                    <p class="mb-3">Menjual berbagai macam produk batik berkualitas dengan harga terjangkau.</p>
                    <div class="d-flex">
                        <a href="#" class="text-white me-3 fs-5">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="text-white me-3 fs-5">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="text-white me-3 fs-5">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="text-white fs-5">
                            <i class="bi bi-tiktok"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="index.php" class="text-white text-decoration-none">
                                <i class="bi bi-chevron-right me-1"></i> Beranda
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#produk" class="text-white text-decoration-none">
                                <i class="bi bi-chevron-right me-1"></i> Produk
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#tentang" class="text-white text-decoration-none">
                                <i class="bi bi-chevron-right me-1"></i> Tentang Kami
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#kontak" class="text-white text-decoration-none">
                                <i class="bi bi-chevron-right me-1"></i> Kontak
                            </a>
                        </li>
                        <?php if(!isAdminLoggedIn()): ?>
                        <li>
                            <a href="login.php" class="text-white text-decoration-none">
                                <i class="bi bi-chevron-right me-1"></i> Login Admin
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Kontak Kami</h5>
                    <p class="mb-2">
                        <i class="bi bi-envelope me-2"></i> info@batiknusantara.com
                    </p>
                    <p class="mb-2">
                        <i class="bi bi-telephone me-2"></i> (021) 123-4567
                    </p>
                    <p class="mb-2">
                        <i class="bi bi-whatsapp me-2"></i> +62 812-3456-7890
                    </p>
                    <p>
                        <i class="bi bi-geo-alt me-2"></i> Jl. Batik No. 123, Jakarta
                    </p>
                </div>
            </div>
            <hr class="bg-light my-4">
            <div class="text-center">
                <p class="mb-0">
                    &copy; 2025 Toko Batik Nusantara. Dibuat oleh Rifqi Ramdani.
                </p>
                <small class="text-muted">
                    PPW_2311104044_RifqiMRamdani - PERTEMUAN_10_MODUL_10
                </small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (optional, for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/bootstrap-custom.js"></script>
    
    <script>
        // Smooth scroll untuk anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const target = document.querySelector(targetId);
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 70,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Filter produk berdasarkan kategori
        document.querySelectorAll('[data-filter]').forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                // Update active button
                document.querySelectorAll('[data-filter]').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
                
                // Filter products
                const products = document.querySelectorAll('#productContainer > div');
                products.forEach(product => {
                    if (filter === 'all' || product.getAttribute('data-category') === filter) {
                        product.style.display = 'block';
                        product.classList.add('animate-card');
                    } else {
                        product.style.display = 'none';
                    }
                });
            });
        });
        
        // Add to cart functionality
        document.querySelectorAll('.btn-add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                
                // Show toast notification
                const toast = new bootstrap.Toast(document.createElement('div'));
                const toastElement = document.createElement('div');
                toastElement.className = 'toast align-items-center text-bg-success border-0';
                toastElement.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-check-circle me-2"></i>
                            ${productName} berhasil ditambahkan ke keranjang
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                `;
                
                document.querySelector('.toast-container')?.appendChild(toastElement) || 
                (() => {
                    const container = document.createElement('div');
                    container.className = 'toast-container position-fixed top-0 end-0 p-3';
                    document.body.appendChild(container);
                    container.appendChild(toastElement);
                    return container;
                })();
                
                const bsToast = new bootstrap.Toast(toastElement);
                bsToast.show();
                
                // Update cart count (simulated)
                const cartCount = document.querySelector('.cart-count');
                if (cartCount) {
                    let count = parseInt(cartCount.textContent) || 0;
                    cartCount.textContent = count + 1;
                    cartCount.classList.add('bounce');
                    setTimeout(() => cartCount.classList.remove('bounce'), 300);
                }
            });
        });
        
        // Quick view functionality
        document.querySelectorAll('.btn-quick-view').forEach(button => {
            button.addEventListener('click', async function() {
                const productId = this.getAttribute('data-id');
                
                // Show loading
                const modalContent = document.getElementById('quickViewContent');
                modalContent.innerHTML = `
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `;
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
                modal.show();
                
                // Load product details (simulated)
                setTimeout(() => {
                    // In a real app, you would fetch from API
                    modalContent.innerHTML = `
                        <div class="row">
                            <div class="col-md-6">
                                <img src="uploads/produk${productId}.jpg" 
                                     class="img-fluid rounded" 
                                     alt="Product Image"
                                     onerror="this.src='https://placehold.co/400x400?text=Product+Image'">
                            </div>
                            <div class="col-md-6">
                                <h4>Product Name ${productId}</h4>
                                <p class="text-muted">This is a detailed description of the product.</p>
                                <h5 class="text-danger">Rp 199,999</h5>
                                <p>Stok: <span class="badge bg-success">50</span></p>
                                <div class="mt-4">
                                    <button class="btn btn-primary w-100 mb-2">
                                        <i class="bi bi-cart me-1"></i> Tambah ke Keranjang
                                    </button>
                                    <button class="btn btn-outline-primary w-100">
                                        <i class="bi bi-heart me-1"></i> Tambah ke Wishlist
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                }, 500);
            });
        });
        
        // Newsletter form
        document.getElementById('newsletterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            
            // Simulate subscription
            const toastElement = document.createElement('div');
            toastElement.className = 'toast align-items-center text-bg-success border-0';
            toastElement.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-envelope-check me-2"></i>
                        Terima kasih! Anda telah berlangganan newsletter kami.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            
            document.querySelector('.toast-container')?.appendChild(toastElement) || 
            (() => {
                const container = document.createElement('div');
                container.className = 'toast-container position-fixed top-0 end-0 p-3';
                document.body.appendChild(container);
                container.appendChild(toastElement);
                return container;
            })();
            
            const bsToast = new bootstrap.Toast(toastElement);
            bsToast.show();
            
            this.reset();
        });
        
        // Back to top button
        window.addEventListener('scroll', function() {
            const backToTop = document.querySelector('.back-to-top');
            if (window.pageYOffset > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });
        
        // Initialize animations on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-card');
                }
            });
        }, observerOptions);
        
        // Observe all product cards
        document.querySelectorAll('.product-card').forEach(card => {
            observer.observe(card);
        });
        
        // Handle page load animations
        window.addEventListener('load', function() {
            document.body.classList.add('loaded');
        });
        
        // Cart count animation
        const style = document.createElement('style');
        style.textContent = `
            .bounce {
                animation: bounce 0.3s ease;
            }
            @keyframes bounce {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.3); }
            }
            .cart-count {
                position: absolute;
                top: -5px;
                right: -5px;
                background: #dc3545;
                color: white;
                border-radius: 50%;
                width: 18px;
                height: 18px;
                font-size: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        `;
        document.head.appendChild(style);
        
        // Add cart icon to navbar
        const nav = document.querySelector('.navbar-nav');
        const cartItem = document.createElement('li');
        cartItem.className = 'nav-item position-relative';
        cartItem.innerHTML = `
            <a class="nav-link" href="#">
                <i class="bi bi-cart3"></i>
                <span class="cart-count">0</span>
            </a>
        `;
        nav.insertBefore(cartItem, nav.lastElementChild);
    </script>
</body>
</html>
<?php mysqli_close($conn); ?>