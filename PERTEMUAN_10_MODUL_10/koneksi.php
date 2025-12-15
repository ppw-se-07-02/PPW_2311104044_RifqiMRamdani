<?php
session_start();

// Konfigurasi database
$host = "localhost";
$username = "root";
$password = "";
$database = "toko_batik";

// Buat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set charset UTF-8
mysqli_set_charset($conn, "utf8");

/**
 * Cek apakah admin sudah login
 */
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

/**
 * Redirect ke login jika belum login
 */
function requireLogin() {
    if (!isAdminLoggedIn()) {
        $_SESSION['error'] = "Silakan login terlebih dahulu!";
        header("Location: ../login.php");
        exit();
    }
}

/**
 * Escape string untuk keamanan
 */
function escape($conn, $string) {
    return mysqli_real_escape_string($conn, $string);
}

/**
 * Redirect dengan pesan sukses
 */
function redirectSuccess($url, $message) {
    $_SESSION['success'] = $message;
    header("Location: $url");
    exit();
}

/**
 * Redirect dengan pesan error
 */
function redirectError($url, $message) {
    $_SESSION['error'] = $message;
    header("Location: $url");
    exit();
}
?>