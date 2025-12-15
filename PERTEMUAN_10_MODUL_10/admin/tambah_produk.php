<?php
require_once "../koneksi.php";
requireLogin();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .main-content {
            padding: 20px;
        }
        .preview-img {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            border: 2px dashed #dee2e6;
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
                    <i class="bi bi-plus-circle me-2"></i> Tambah Produk Baru
                </h1>
                <a href="kelola_produk.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            
            <!-- Form -->
            <div class="card">
                <div class="card-body">
                    <form action="proses_tambah.php" method="POST" enctype="multipart/form-data" id="formTambah">
                        <div class="row g-3">
                            <!-- Nama Produk -->
                            <div class="col-md-8">
                                <label for="nama" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" required
                                       placeholder="Contoh: Hijab Batik Semi Sutra Aurora Olive Heritage">
                            </div>
                            
                            <!-- Kategori -->
                            <div class="col-md-4">
                                <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="kategori" name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Hijab">Hijab</option>
                                    <option value="Pakaian Pria">Pakaian Pria</option>
                                    <option value="Pakaian Wanita">Pakaian Wanita</option>
                                    <option value="Aksesoris">Aksesoris</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            
                            <!-- Harga -->
                            <div class="col-md-4">
                                <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="harga" name="harga" 
                                           min="1000" required placeholder="89999">
                                </div>
                            </div>
                            
                            <!-- Stok -->
                            <div class="col-md-4">
                                <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="stok" name="stok" 
                                       min="0" value="0" required>
                            </div>
                            
                            <!-- Gambar -->
                            <div class="col-md-4">
                                <label for="gambar" class="form-label">Gambar Produk</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" 
                                       accept="image/*" onchange="previewImage(event)">
                                <small class="text-muted">Format: JPG, PNG, WEBP. Maks 2MB</small>
                            </div>
                            
                            <!-- Preview Gambar -->
                            <div class="col-12 text-center mt-2">
                                <img id="preview" class="preview-img" 
                                     src="https://placehold.co/200x200?text=Preview+Gambar"
                                     alt="Preview Gambar">
                            </div>
                            
                            <!-- Deskripsi -->
                            <div class="col-12">
                                <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" 
                                          rows="4" placeholder="Deskripsi lengkap produk..."></textarea>
                            </div>
                            
                            <!-- Tombol -->
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-between">
                                    <button type="reset" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-1"></i> Reset Form
                                    </button>
                                    <button type="submit" class="btn btn-success px-5">
                                        <i class="bi bi-save me-1"></i> Simpan Produk
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        // Preview gambar
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.borderColor = '#0d6efd';
                }
                reader.readAsDataURL(file);
            }
        }
        
        // Validasi form
        document.getElementById('formTambah').addEventListener('submit', function(e) {
            const harga = document.getElementById('harga').value;
            const stok = document.getElementById('stok').value;
            
            if (harga < 1000) {
                alert('Harga minimal Rp 1.000');
                e.preventDefault();
                return false;
            }
            
            if (stok < 0) {
                alert('Stok tidak boleh negatif');
                e.preventDefault();
                return false;
            }
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>