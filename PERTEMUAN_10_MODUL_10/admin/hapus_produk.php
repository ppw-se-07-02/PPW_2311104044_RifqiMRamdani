<?php
require_once "../koneksi.php";
requireLogin();

// File ini sudah tidak digunakan karena hapus diproses di kelola_produk.php
// Redirect ke kelola_produk jika diakses langsung
header("Location: kelola_produk.php");
exit();
?>