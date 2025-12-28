<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
</head>
<body>

<header>
    <h2>Website Laravel - Modul 11</h2>
    <hr>
</header>

<main>
    @yield('content')
</main>

<footer>
    <hr>
    <p>&copy; 2025 - Rifqi Ramdani</p>
</footer>

<!-- JS -->
<script src="{{ asset('asset/js/script.js') }}"></script>

</body>
</html>
