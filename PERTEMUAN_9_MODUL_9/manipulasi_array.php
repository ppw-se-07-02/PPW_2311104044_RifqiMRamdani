<?php
// Manipulasi Array Nilai Mahasiswa
// Input: array nilai
// Output: tertinggi, terendah, rata-rata, jumlah lulus, dan hasil pengurutan

$nilai = [75, 89, 65, 90, 85, 70, 98, 65, 69, 70, 12];

$nilaiTertinggi = max($nilai);
$nilaiTerendah = min($nilai);

$rataRata = array_sum($nilai) / count($nilai);

$lulus = 0;
foreach ($nilai as $n) {
    if ($n >= 70) $lulus++;
}

$nilaiDesc = $nilai; // salin array
rsort($nilaiDesc); // urutkan dari tertinggi ke terendah

echo "<h2>Manipulasi Array Nilai Mahasiswa</h2>";
echo "Nilai: " . implode(", ", $nilai) . "<br><br>";
echo "Nilai Tertinggi: <strong>" . $nilaiTertinggi . "</strong><br>";
echo "Nilai Terendah: <strong>" . $nilaiTerendah . "</strong><br>";
echo "Rata-rata Nilai: <strong>" . number_format($rataRata, 2) . "</strong><br>";
echo "Jumlah Mahasiswa Lulus (≥70): <strong>" . $lulus . "</strong><br>";
echo "Nilai Terurut (Tinggi → Rendah): " . implode(", ", $nilaiDesc) . "<br>";
?>