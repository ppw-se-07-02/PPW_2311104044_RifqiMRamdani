<?php
require_once "../koneksi.php";
requireLogin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = (int)$_POST['harga'];
    $stok = (int)$_POST['stok'];
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    
    // Default: gunakan gambar lama
    $gambar_query = "";
    
    // Cek apakah ada upload gambar baru
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $filename = $_FILES['gambar']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed) && $_FILES['gambar']['size'] < 2097152) {
            // Hapus gambar lama jika bukan default.jpg
            $query_old = "SELECT gambar FROM produk WHERE id = $id";
            $result_old = mysqli_query($conn, $query_old);
            $old_data = mysqli_fetch_assoc($result_old);
            
            if ($old_data['gambar'] != 'default.jpg') {
                $old_file = "../uploads/" . $old_data['gambar'];
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }
            
            // Upload gambar baru
            $gambar_baru = uniqid() . '.' . $ext;
            $target = "../uploads/" . $gambar_baru;
            
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                $gambar_query = ", gambar = '$gambar_baru'";
            }
        }
    }
    
    // Query update
    $query = "UPDATE produk SET 
              nama = '$nama',
              deskripsi = '$deskripsi',
              harga = $harga,
              stok = $stok,
              kategori = '$kategori'
              $gambar_query
              WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "✅ Produk berhasil diupdate!";
        header("Location: kelola_produk.php");
        exit();
    } else {
        $_SESSION['error'] = "❌ Gagal mengupdate produk: " . mysqli_error($conn);
        header("Location: edit_produk.php?id=$id");
        exit();
    }
} else {
    header("Location: kelola_produk.php");
    exit();
}
?>