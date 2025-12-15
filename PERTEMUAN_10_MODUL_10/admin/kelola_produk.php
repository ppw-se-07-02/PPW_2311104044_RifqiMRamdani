<?php
require_once "../koneksi.php";
requireLogin();
require_once "../proses_cari.php";

// Proses pencarian
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$keyword_bersih = bersihkanKeyword($keyword);

if (!empty($keyword_bersih)) {
    // Gunakan fungsi pencarian
    $result = cariProduk($conn, $keyword_bersih);
    $jumlah = hitungHasilCari($result);
    $pesan = "Ditemukan <strong>$jumlah</strong> produk dengan kata kunci: <strong>'$keyword_bersih'</strong>";
} else {
    // Tampilkan semua produk
    $query = "SELECT * FROM produk ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    $jumlah = mysqli_num_rows($result);
    $pesan = "Menampilkan semua <strong>$jumlah</strong> produk";
}

// Proses hapus
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    $query_hapus = "DELETE FROM produk WHERE id = $id_hapus";
    
    if (mysqli_query($conn, $query_hapus)) {
        $_SESSION['success'] = "Produk berhasil dihapus!";
        header("Location: kelola_produk.php");
        exit();
    } else {
        $_SESSION['error'] = "Gagal menghapus produk: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .main-content {
            padding: 20px;
        }
        .table th {
            background-color: #0d6efd;
            color: white;
            vertical-align: middle;
        }
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .action-buttons .btn {
            padding: 5px 10px;
            font-size: 12px;
        }
        .search-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <?php include "sidebar.php"; ?>
        
        <main class="main-content flex-grow-1">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 text-primary">
                    <i class="bi bi-box-seam me-2"></i> Kelola Produk
                </h1>
                <a href="tambah_produk.php" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Produk
                </a>
            </div>
            
            <!-- Pesan -->
            <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); endif; ?>
            
            <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); endif; ?>
            
            <!-- Search Box -->
            <div class="search-box">
                <form method="GET" action="" class="row g-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="keyword" class="form-control" 
                                   placeholder="Cari produk berdasarkan nama, deskripsi, atau kategori..."
                                   value="<?= htmlspecialchars($keyword) ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                    </div>
                    <div class="col-md-2">
                        <?php if(!empty($keyword)): ?>
                        <a href="kelola_produk.php" class="btn btn-secondary w-100">
                            <i class="bi bi-x-circle me-1"></i> Reset
                        </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            
            <!-- Info Hasil -->
            <div class="alert alert-info d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-info-circle me-2"></i>
                    <?= $pesan ?>
                </div>
                <?php if($jumlah > 0): ?>
                <a href="tambah_produk.php" class="btn btn-sm btn-success">
                    <i class="bi bi-plus-circle"></i> Tambah Baru
                </a>
                <?php endif; ?>
            </div>
            
            <?php if($jumlah > 0): ?>
            <!-- Table Produk -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="50">ID</th>
                                    <th width="100">Gambar</th>
                                    <th>Nama Produk</th>
                                    <th width="120">Harga</th>
                                    <th width="80">Stok</th>
                                    <th width="100">Kategori</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $row['id'] ?></td>
                                    <td>
                                        <img src="../uploads/<?= $row['gambar'] ?>" 
                                             alt="<?= htmlspecialchars($row['nama']) ?>"
                                             class="product-img">
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($row['nama']) ?></strong>
                                        <br>
                                        <small class="text-muted">
                                            <?= substr(htmlspecialchars($row['deskripsi']), 0, 50) ?>...
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger fs-6">
                                            Rp <?= number_format($row['harga'], 0, ',', '.') ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if($row['stok'] > 10): ?>
                                            <span class="badge bg-success"><?= $row['stok'] ?></span>
                                        <?php elseif($row['stok'] > 0): ?>
                                            <span class="badge bg-warning"><?= $row['stok'] ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Habis</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?= $row['kategori'] ?></span>
                                    </td>
                                    <td class="action-buttons">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="edit_produk.php?id=<?= $row['id'] ?>" 
                                               class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="kelola_produk.php?hapus=<?= $row['id'] ?>" 
                                               class="btn btn-danger" 
                                               title="Hapus"
                                               onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                            <a href="../index.php" 
                                               target="_blank" 
                                               class="btn btn-info" title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
            
            <?php else: ?>
            <!-- Kosong -->
            <div class="text-center py-5">
                <?php if(!empty($keyword)): ?>
                <div class="text-warning">
                    <i class="bi bi-search display-4"></i>
                    <h4 class="mt-3">Produk tidak ditemukan</h4>
                    <p class="text-muted">Tidak ada produk yang sesuai dengan kata kunci "<strong><?= htmlspecialchars($keyword) ?></strong>"</p>
                    <a href="kelola_produk.php" class="btn btn-primary mt-2">
                        <i class="bi bi-arrow-left me-1"></i> Tampilkan Semua Produk
                    </a>
                </div>
                <?php else: ?>
                <div class="text-muted">
                    <i class="bi bi-box display-4"></i>
                    <h4 class="mt-3">Belum ada produk</h4>
                    <p>Mulai tambahkan produk pertama Anda</p>
                    <a href="tambah_produk.php" class="btn btn-success mt-2">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Produk Pertama
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>