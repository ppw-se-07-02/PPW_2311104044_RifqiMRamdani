<?php
// Program Konversi Suhu
// Konversi: Celsius ↔ Fahrenheit, Celsius ↔ Kelvin

function celsiusToFahrenheit($celsius) {
    return ($celsius * 9/5) + 32;
}

function fahrenheitToCelsius($fahrenheit) {
    return ($fahrenheit - 32) * 5/9;
}

function celsiusToKelvin($celsius) {
    return $celsius + 273.15;
}

// Contoh nilai
$celsius = 25;
$fahrenheit = 77;

echo "<h2>Program Konversi Suhu</h2>";
echo "<p>Contoh konversi dari 25°C dan 77°F:</p>";
echo "Celsius ke Fahrenheit: " . number_format(celsiusToFahrenheit($celsius), 2) . " °F<br>";
echo "Fahrenheit ke Celsius: " . number_format(fahrenheitToCelsius($fahrenheit), 2) . " °C<br>";
echo "Celsius ke Kelvin: " . number_format(celsiusToKelvin($celsius), 2) . " K<br>";
?>