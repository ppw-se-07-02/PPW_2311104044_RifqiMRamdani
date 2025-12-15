<?php
/**
 * File: proses_cari.php
 * Fungsi: Logika pencarian data produk
 */

/**
 * Bersihkan keyword dari karakter berbahaya
 */
function bersihkanKeyword($keyword) {
    $keyword = strip_tags($keyword);
    $keyword = trim($keyword);
    $keyword = preg_replace('/[^\p{L}\p{N}\s]/u', '', $keyword); // Hanya huruf, angka, spasi
    return $keyword;
}

/**
 * Cari produk berdasarkan keyword
 */
function cariProduk($conn, $keyword) {
    $keyword = mysqli_real_escape_string($conn, $keyword);
    
    $query = "SELECT * FROM produk 
              WHERE nama LIKE '%$keyword%' 
              OR deskripsi LIKE '%$keyword%' 
              OR kategori LIKE '%$keyword%'
              ORDER BY id DESC";
    
    return mysqli_query($conn, $query);
}

/**
 * Hitung jumlah hasil pencarian
 */
function hitungHasilCari($result) {
    return mysqli_num_rows($result);
}

/**
 * Cari produk dengan pagination
 */
function cariProdukPagination($conn, $keyword, $limit = 10, $offset = 0) {
    $keyword = mysqli_real_escape_string($conn, $keyword);
    
    $query = "SELECT * FROM produk 
              WHERE nama LIKE '%$keyword%' 
              OR deskripsi LIKE '%$keyword%' 
              OR kategori LIKE '%$keyword%'
              ORDER BY id DESC
              LIMIT $limit OFFSET $offset";
    
    return mysqli_query($conn, $query);
}

/**
 * Get keyword populer dari log pencarian
 */
function getKeywordPopuler($conn, $limit = 5) {
    // Cek apakah tabel log_pencarian ada
    $checkTable = mysqli_query($conn, "SHOW TABLES LIKE 'log_pencarian'");
    
    if (mysqli_num_rows($checkTable) > 0) {
        $query = "SELECT keyword, COUNT(*) as jumlah 
                  FROM log_pencarian 
                  GROUP BY keyword 
                  ORDER BY jumlah DESC 
                  LIMIT $limit";
        
        $result = mysqli_query($conn, $query);
        $keywords = [];
        
        while ($row = mysqli_fetch_assoc($result)) {
            $keywords[] = $row;
        }
        
        return $keywords;
    }
    
    return [];
}
?>