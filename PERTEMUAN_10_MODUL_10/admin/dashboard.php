<?php
require_once "../koneksi.php";
requireLogin();

// Ambil statistik
$query_produk = "SELECT COUNT(*) as total FROM produk";
$result_produk = mysqli_query($conn, $query_produk);
$total_produk = mysqli_fetch_assoc($result_produk)['total'];

$query_stok = "SELECT SUM(stok) as total_stok FROM produk";
$result_stok = mysqli_query($conn, $query_stok);
$total_stok = mysqli_fetch_assoc($result_stok)['total_stok'] ?? 0;

$query_habis = "SELECT COUNT(*) as habis FROM produk WHERE stok = 0";
$result_habis = mysqli_query($conn, $query_habis);
$produk_habis = mysqli_fetch_assoc($result_habis)['habis'];

$query_kategori = "SELECT kategori, COUNT(*) as jumlah FROM produk GROUP BY kategori";
$result_kategori = mysqli_query($conn, $query_kategori);

// Produk terbaru
$query_terbaru = "SELECT * FROM produk ORDER BY created_at DESC LIMIT 5";
$result_terbaru = mysqli_query($conn, $query_terbaru);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .main-content {
            padding: 20px;
        }
        .stat-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Include Sidebar -->
        <?php include "sidebar.php"; ?>
        
        <!-- Main Content -->
        <main class="main-content flex-grow-1">
            <!-- Welcome Card -->
            <div class="card welcome-card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-10">
                            <h2 class="card-title">Selamat datang, <?= htmlspecialchars($_SESSION['admin_name']) ?>! 👋</h2>
                            <p class="card-text">Anda login sebagai Administrator Toko Batik Nusantara</p>
                            <a href="kelola_produk.php" class="btn btn-light">
                                <i class="bi bi-box-seam me-1"></i> Kelola Produk
                            </a>
                        </div>
                        <div class="col-md-2 text-end">
                            <i class="bi bi-person-circle stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Statistik Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card stat-card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Total Produk</h6>
                                    <h2 class="card-title"><?= $total_produk ?></h2>
                                </div>
                                <i class="bi bi-box stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card stat-card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Total Stok</h6>
                                    <h2 class="card-title"><?= $total_stok ?></h2>
                                </div>
                                <i class="bi bi-archive stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card stat-card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Produk Habis</h6>
                                    <h2 class="card-title"><?= $produk_habis ?></h2>
                                </div>
                                <i class="bi bi-exclamation-triangle stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card stat-card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Kategori</h6>
                                    <h2 class="card-title">
                                        <?php echo mysqli_num_rows($result_kategori); ?>
                                    </h2>
                                </div>
                                <i class="bi bi-tags stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Produk Terbaru & Kategori -->
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i> Produk Terbaru</h5>
                            <a href="kelola_produk.php" class="btn btn-sm btn-light">Lihat Semua</a>
                        </div>
                        <div class="card-body">
                            <?php if(mysqli_num_rows($result_terbaru) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Produk</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($produk = mysqli_fetch_assoc($result_terbaru)): ?>
                                        <tr>
                                            <td><?= $produk['id'] ?></td>
                                            <td>
                                                <strong><?= htmlspecialchars($produk['nama']) ?></strong>
                                                <br>
                                                <small class="text-muted"><?= $produk['kategori'] ?></small>
                                            </td>
                                            <td>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></td>
                                            <td>
                                                <?php if($produk['stok'] > 10): ?>
                                                    <span class="badge bg-success"><?= $produk['stok'] ?></span>
                                                <?php elseif($produk['stok'] > 0): ?>
                                                    <span class="badge bg-warning"><?= $produk['stok'] ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Habis</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($produk['created_at'])) ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-box text-muted display-4"></i>
                                <p class="text-muted mt-2">Belum ada produk</p>
                                <a href="tambah_produk.php" class="btn btn-primary">Tambah Produk</a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Kategori -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-tags me-2"></i> Kategori Produk</h5>
                        </div>
                        <div class="card-body">
                            <?php 
                            mysqli_data_seek($result_kategori, 0); // Reset pointer
                            if(mysqli_num_rows($result_kategori) > 0): ?>
                            <div class="list-group">
                                <?php while($kategori = mysqli_fetch_assoc($result_kategori)): ?>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <?= htmlspecialchars($kategori['kategori']) ?>
                                    <span class="badge bg-primary rounded-pill"><?= $kategori['jumlah'] ?></span>
                                </a>
                                <?php endwhile; ?>
                            </div>
                            <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-tag text-muted display-4"></i>
                                <p class="text-muted mt-2">Belum ada kategori</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="card mt-4">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="bi bi-lightning me-2"></i> Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="tambah_produk.php" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i> Tambah Produk Baru
                                </a>
                                <a href="kelola_produk.php" class="btn btn-success">
                                    <i class="bi bi-box-seam me-2"></i> Kelola Produk
                                </a>
                                <a href="../index.php" target="_blank" class="btn btn-info">
                                    <i class="bi bi-eye me-2"></i> Lihat Website
                                </a>
                                <a href="logout.php" class="btn btn-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>