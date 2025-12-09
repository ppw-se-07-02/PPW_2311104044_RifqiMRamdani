<?php
// Kalkulator Diskon
// Input: total belanja
// Diskon: 10% (≥100k), 20% (≥500k), 30% (≥1jt)

function hitungDiskon($totalBelanja) {
    if ($totalBelanja >= 1000000) {
        return 30;
    } elseif ($totalBelanja >= 500000) {
        return 20;
    } elseif ($totalBelanja >= 100000) {
        return 10;
    } else {
        return 0;
    }
}

// Contoh nilai
$totalBelanja = 750000;

$diskonPersen = hitungDiskon($totalBelanja);
$jumlahDiskon = ($diskonPersen / 100) * $totalBelanja;
$totalBayar = $totalBelanja - $jumlahDiskon;

echo "<h2>Kalkulator Diskon</h2>";
echo "<p>Total Belanja: Rp " . number_format($totalBelanja, 0, ',', '.') . "</p>";
echo "Diskon: " . $diskonPersen . "%<br>";
echo "Jumlah Diskon: Rp " . number_format($jumlahDiskon, 0, ',', '.') . "<br>";
echo "<strong>Total Bayar: Rp " . number_format($totalBayar, 0, ',', '.') . "</strong><br>";
?>