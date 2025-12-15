<?php
require_once "../koneksi.php";
requireLogin();
?>
<!-- Sidebar -->
<div class="d-flex flex-column flex-shrink-0 p-3 bg-light border-end" style="width: 280px; min-height: 100vh;">
    <!-- Logo -->
    <a href="dashboard.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
        <i class="bi bi-shop fs-4 text-primary me-2"></i>
        <span class="fs-4 fw-bold text-primary">Admin Panel</span>
    </a>
    <hr>
    
    <!-- Menu -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : 'link-dark' ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="kelola_produk.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'kelola_produk.php' ? 'active' : 'link-dark' ?>">
                <i class="bi bi-box-seam me-2"></i> Kelola Produk
            </a>
        </li>
        <li>
            <a href="tambah_produk.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'tambah_produk.php' ? 'active' : 'link-dark' ?>">
                <i class="bi bi-plus-circle me-2"></i> Tambah Produk
            </a>
        </li>
        <li>
            <a href="#" class="nav-link link-dark">
                <i class="bi bi-people me-2"></i> Kelola User
            </a>
        </li>
        <li>
            <a href="#" class="nav-link link-dark">
                <i class="bi bi-gear me-2"></i> Settings
            </a>
        </li>
    </ul>
    <hr>
    
    <!-- User Info -->
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle fs-4 me-2 text-primary"></i>
            <div>
                <strong><?= htmlspecialchars($_SESSION['admin_name']) ?></strong>
                <small class="d-block text-muted">Administrator</small>
            </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark shadow">
            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Sign out</a></li>
        </ul>
    </div>
</div>