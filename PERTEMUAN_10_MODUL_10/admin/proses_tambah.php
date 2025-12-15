<?php
require_once "../koneksi.php";
requireLogin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = (int)$_POST['harga'];
    $stok = (int)$_POST['stok'];
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    
    // Default gambar
    $gambar = "default.jpg";
    
    // Upload gambar jika ada
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $filename = $_FILES['gambar']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            if ($_FILES['gambar']['size'] < 2097152) { // 2MB
                $gambar = uniqid() . '.' . $ext;
                $target = "../uploads/" . $gambar;
                
                if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                    $gambar = "default.jpg";
                }
            }
        }
    }
    
    // Query insert
    $query = "INSERT INTO produk (nama, deskripsi, harga, gambar, stok, kategori) 
              VALUES ('$nama', '$deskripsi', $harga, '$gambar', $stok, '$kategori')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "✅ Produk berhasil ditambahkan!";
        header("Location: kelola_produk.php");
        exit();
    } else {
        $_SESSION['error'] = "❌ Gagal menambahkan produk: " . mysqli_error($conn);
        header("Location: tambah_produk.php");
        exit();
    }
} else {
    header("Location: tambah_produk.php");
    exit();
}
?>