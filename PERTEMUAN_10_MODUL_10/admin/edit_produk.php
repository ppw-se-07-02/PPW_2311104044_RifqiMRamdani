<?php
require_once "../koneksi.php";
requireLogin();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: kelola_produk.php");
    exit();
}

$id = (int)$_GET['id'];
$query = "SELECT * FROM produk WHERE id = $id LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    $_SESSION['error'] = "Produk tidak ditemukan!";
    header("Location: kelola_produk.php");
    exit();
}

$produk = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .main-content {
            padding: 20px;
        }
        .current-img {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 5px;
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
                    <i class="bi bi-pencil me-2"></i> Edit Produk
                </h1>
                <a href="kelola_produk.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            
            <!-- Form Edit -->
            <div class="card">
                <div class="card-body">
                    <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $produk['id'] ?>">
                        
                        <div class="row g-3">
                            <!-- Nama -->
                            <div class="col-md-8">
                                <label for="nama" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="nama" name="nama" 
                                       value="<?= htmlspecialchars($produk['nama']) ?>" required>
                            </div>
                            
                            <!-- Kategori -->
                            <div class="col-md-4">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-select" id="kategori" name="kategori" required>
                                    <option value="Hijab" <?= $produk['kategori'] == 'Hijab' ? 'selected' : '' ?>>Hijab</option>
                                    <option value="Pakaian Pria" <?= $produk['kategori'] == 'Pakaian Pria' ? 'selected' : '' ?>>Pakaian Pria</option>
                                    <option value="Pakaian Wanita" <?= $produk['kategori'] == 'Pakaian Wanita' ? 'selected' : '' ?>>Pakaian Wanita</option>
                                    <option value="Aksesoris" <?= $produk['kategori'] == 'Aksesoris' ? 'selected' : '' ?>>Aksesoris</option>
                                    <option value="Lainnya" <?= $produk['kategori'] == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                            </div>
                            
                            <!-- Harga -->
                            <div class="col-md-4">
                                <label for="harga" class="form-label">Harga (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="harga" name="harga" 
                                           value="<?= $produk['harga'] ?>" min="1000" required>
                                </div>
                            </div>
                            
                            <!-- Stok -->
                            <div class="col-md-4">
                                <label for="stok" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stok" name="stok" 
                                       value="<?= $produk['stok'] ?>" min="0" required>
                            </div>
                            
                            <!-- Gambar -->
                            <div class="col-md-4">
                                <label for="gambar" class="form-label">Gambar Baru (Opsional)</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" 
                                       accept="image/*">
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti</small>
                            </div>
                            
                            <!-- Gambar Saat Ini -->
                            <div class="col-12 text-center">
                                <p class="mb-1">Gambar Saat Ini:</p>
                                <img src="../uploads/<?= $produk['gambar'] ?>" 
                                     class="current-img" 
                                     alt="Gambar Produk">
                                <p class="text-muted small mt-1"><?= $produk['gambar'] ?></p>
                            </div>
                            
                            <!-- Deskripsi -->
                            <div class="col-12">
                                <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"><?= htmlspecialchars($produk['deskripsi']) ?></textarea>
                            </div>
                            
                            <!-- Tombol -->
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-between">
                                    <a href="kelola_produk.php" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-1"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary px-5">
                                        <i class="bi bi-save me-1"></i> Update Produk
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>