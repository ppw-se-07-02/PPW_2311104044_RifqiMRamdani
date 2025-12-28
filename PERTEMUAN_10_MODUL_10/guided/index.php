<?php
// ==================== KONEKSI DATABASE ====================
$host = "localhost";
$username = "root";
$password = "";
$database = "akademik";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");

// ==================== FUNGSI PENCARIAN ====================
function cariMahasiswa($conn, $keyword) {
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $query = "SELECT * FROM mahasiswa 
              WHERE nim LIKE '%$keyword%' 
              OR nama LIKE '%$keyword%' 
              OR jurusan LIKE '%$keyword%' 
              ORDER BY nim ASC";
    return mysqli_query($conn, $query);
}

function hitungHasilCari($result) {
    return mysqli_num_rows($result);
}

// ==================== LOGIKA HAPUS ====================
if (isset($_GET['hapus'])) {
    $nim = $_GET['hapus'];
    $query = "DELETE FROM mahasiswa WHERE nim='$nim'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location.href='index.php';</script>";
    }
}

// ==================== LOGIKA TAMBAH ====================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $email = $_POST['email'] ?? '';
    $tanggal_lahir = $_POST['tanggal_lahir'] ?? '';

    $cek_nim = mysqli_query($conn, "SELECT nim FROM mahasiswa WHERE nim='$nim'");
    if (mysqli_num_rows($cek_nim) > 0) {
        echo "<script>alert('NIM sudah terdaftar!');</script>";
    } else {
        $query = "INSERT INTO mahasiswa (nim, nama, jurusan, email, tanggal_lahir) 
                  VALUES ('$nim', '$nama', '$jurusan', '$email', '$tanggal_lahir')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data!');</script>";
        }
    }
}

// ==================== LOGIKA EDIT ====================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $email = $_POST['email'] ?? '';
    $tanggal_lahir = $_POST['tanggal_lahir'] ?? '';

    $query = "UPDATE mahasiswa SET 
              nama='$nama', 
              jurusan='$jurusan', 
              email='$email', 
              tanggal_lahir='$tanggal_lahir' 
              WHERE nim='$nim'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil diupdate!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data!');</script>";
    }
}

// ==================== AMBIL DATA UNTUK EDIT ====================
$data_edit = null;
if (isset($_GET['edit'])) {
    $nim_edit = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim='$nim_edit'");
    $data_edit = mysqli_fetch_assoc($result);
}

// ==================== AMBIL DATA UNTUK TAMPIL ====================
$keyword = $_GET['keyword'] ?? '';
if ($keyword != '') {
    $result = cariMahasiswa($conn, $keyword);
    $jumlah = hitungHasilCari($result);
} else {
    $query = "SELECT * FROM mahasiswa ORDER BY nim ASC";
    $result = mysqli_query($conn, $query);
    $jumlah = mysqli_num_rows($result);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Mahasiswa</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f4f6f9;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        header {
            background: linear-gradient(135deg, #2c3e50, #4a6491);
            color: white;
            padding: 25px;
            text-align: center;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            display: flex;
            min-height: 600px;
        }
        .sidebar {
            width: 250px;
            background: #34495e;
            padding: 20px;
        }
        .main {
            flex: 1;
            padding: 25px;
        }
        .menu-item {
            color: #ecf0f1;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 5px;
            text-decoration: none;
            display: block;
            transition: all 0.3s;
        }
        .menu-item:hover, .menu-item.active {
            background: #1abc9c;
            color: white;
        }
        .card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-left: 4px solid #3498db;
        }
        .card h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            color: #555;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border 0.3s;
        }
        input:focus, select:focus {
            border-color: #3498db;
            outline: none;
        }
        input[readonly] {
            background: #f8f9fa;
            color: #666;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-primary {
            background: #3498db;
            color: white;
        }
        .btn-primary:hover {
            background: #2980b9;
        }
        .btn-success {
            background: #2ecc71;
            color: white;
        }
        .btn-success:hover {
            background: #27ae60;
        }
        .btn-warning {
            background: #f39c12;
            color: white;
        }
        .btn-warning:hover {
            background: #e67e22;
        }
        .btn-danger {
            background: #e74c3c;
            color: white;
        }
        .btn-danger:hover {
            background: #c0392b;
        }
        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        .search-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .search-box input {
            width: 300px;
            display: inline-block;
            margin-right: 10px;
        }
        .info-text {
            margin: 15px 0;
            color: #555;
            font-size: 15px;
        }
        .keyword-highlight {
            color: #e74c3c;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th {
            background: #34495e;
            color: white;
            padding: 14px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        tr:hover {
            background: #f9f9f9;
        }
        .actions {
            display: flex;
            gap: 8px;
        }
        .actions .btn {
            padding: 6px 12px;
            font-size: 13px;
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
            font-size: 16px;
        }
        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #bdc3c7;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            margin-top: 30px;
            font-size: 14px;
        }
        .required::after {
            content: " *";
            color: #e74c3c;
        }
        @media (max-width: 768px) {
            .content {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
            }
            .search-box input {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📚 Manajemen Data Mahasiswa</h1>
            <p class="subtitle">Sistem CRUD dengan PHP & MySQL - Modul 10</p>
        </header>
        
        <div class="content">
            <nav class="sidebar">
                <a href="#" class="menu-item active">🏠 Dashboard</a>
                <a href="#tambah" class="menu-item">➕ Tambah Mahasiswa</a>
                <a href="#daftar" class="menu-item">📋 Daftar Mahasiswa</a>
                <a href="#cari" class="menu-item">🔍 Pencarian Data</a>
            </nav>
            
            <main class="main">
                <!-- FORM TAMBAH/EDIT -->
                <div class="card" id="tambah">
                    <h3><?php echo $data_edit ? '✏️ Edit Data Mahasiswa' : '➕ Tambah Data Mahasiswa Baru'; ?></h3>
                    <form method="POST">
                        <div class="form-group">
                            <label class="required">NIM</label>
                            <input type="text" name="nim" 
                                   value="<?php echo $data_edit ? $data_edit['nim'] : ''; ?>"
                                   <?php echo $data_edit ? 'readonly' : ''; ?>
                                   required maxlength="10" 
                                   placeholder="Contoh: 20240001">
                        </div>
                        
                        <div class="form-group">
                            <label class="required">Nama Lengkap</label>
                            <input type="text" name="nama" 
                                   value="<?php echo $data_edit ? $data_edit['nama'] : ''; ?>"
                                   required maxlength="50" 
                                   placeholder="Masukkan nama lengkap">
                        </div>
                        
                        <div class="form-group">
                            <label class="required">Jurusan</label>
                            <select name="jurusan" required>
                                <option value="">-- Pilih Jurusan --</option>
                                <option value="Teknik Informatika" <?php echo ($data_edit && $data_edit['jurusan'] == 'Teknik Informatika') ? 'selected' : ''; ?>>Teknik Informatika</option>
                                <option value="Sistem Informasi" <?php echo ($data_edit && $data_edit['jurusan'] == 'Sistem Informasi') ? 'selected' : ''; ?>>Sistem Informasi</option>
                                <option value="Teknologi Informasi" <?php echo ($data_edit && $data_edit['jurusan'] == 'Teknologi Informasi') ? 'selected' : ''; ?>>Teknologi Informasi</option>
                                <option value="Ilmu Komputer" <?php echo ($data_edit && $data_edit['jurusan'] == 'Ilmu Komputer') ? 'selected' : ''; ?>>Ilmu Komputer</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" 
                                   value="<?php echo $data_edit ? $data_edit['email'] : ''; ?>"
                                   maxlength="50" 
                                   placeholder="contoh@email.com">
                        </div>
                        
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" 
                                   value="<?php echo $data_edit ? $data_edit['tanggal_lahir'] : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <?php if ($data_edit): ?>
                                <button type="submit" name="edit" class="btn btn-warning">📝 Update Data</button>
                                <a href="index.php" class="btn btn-secondary">❌ Batal</a>
                            <?php else: ?>
                                <button type="submit" name="tambah" class="btn btn-success">💾 Simpan Data</button>
                                <button type="reset" class="btn btn-secondary">🔄 Reset</button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                
                <!-- PENCARIAN -->
                <div class="card" id="cari">
                    <h3>🔍 Pencarian Data Mahasiswa</h3>
                    <div class="search-box">
                        <form method="GET" action="">
                            <input type="text" name="keyword" 
                                   value="<?php echo htmlspecialchars($keyword); ?>"
                                   placeholder="Cari berdasarkan NIM, Nama, atau Jurusan...">
                            <button type="submit" class="btn btn-primary">🔍 Cari</button>
                            <?php if ($keyword != ''): ?>
                                <a href="index.php" class="btn btn-secondary">🔄 Tampilkan Semua</a>
                            <?php endif; ?>
                        </form>
                    </div>
                    
                    <?php if ($keyword != ''): ?>
                        <p class="info-text">
                            Ditemukan <strong><?php echo $jumlah; ?></strong> data dengan kata kunci: 
                            <span class="keyword-highlight">"<?php echo htmlspecialchars($keyword); ?>"</span>
                        </p>
                    <?php else: ?>
                        <p class="info-text">Menampilkan <strong><?php echo $jumlah; ?></strong> data mahasiswa</p>
                    <?php endif; ?>
                </div>
                
                <!-- DAFTAR MAHASISWA -->
                <div class="card" id="daftar">
                    <h3>📋 Daftar Mahasiswa</h3>
                    
                    <?php if ($jumlah > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Jurusan</th>
                                    <th>Email</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result)): 
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><strong><?php echo htmlspecialchars($row['nim']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($row['jurusan']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo $row['tanggal_lahir']; ?></td>
                                    <td class="actions">
                                        <a href="?edit=<?php echo urlencode($row['nim']); ?>#tambah" 
                                           class="btn btn-warning">✏️ Edit</a>
                                        <a href="?hapus=<?php echo urlencode($row['nim']); ?>" 
                                           class="btn btn-danger" 
                                           onclick="return confirm('Yakin ingin menghapus data ini?')">🗑️ Hapus</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state">
                            <div>📭</div>
                            <p>Tidak ada data mahasiswa ditemukan.</p>
                            <?php if ($keyword != ''): ?>
                                <p>Silakan coba dengan kata kunci lain.</p>
                            <?php else: ?>
                                <p>Silakan tambahkan data mahasiswa terlebih dahulu.</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
        
        <div class="footer">
            <p>© <?php echo date('Y'); ?> - Modul 10 PHP & MySQL | Pemrograman Web 1</p>
            <p>Total Data: <strong><?php echo $jumlah; ?></strong> mahasiswa</p>
        </div>
    </div>

    <script>
        // Smooth scroll untuk menu
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 20,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        // Highlight menu aktif berdasarkan scroll
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('.card');
            const menuItems = document.querySelectorAll('.menu-item');
            
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (scrollY >= sectionTop - 100) {
                    current = section.getAttribute('id');
                }
            });
            
            menuItems.forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('href') === `#${current}`) {
                    item.classList.add('active');
                }
            });
        });

        // Konfirmasi sebelum hapus
        document.querySelectorAll('.btn-danger').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Yakin ingin menghapus data ini?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
<?php
mysqli_close($conn);
?>