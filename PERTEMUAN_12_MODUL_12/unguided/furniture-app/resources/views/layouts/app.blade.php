<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Mitra Furniture - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #D0E2FF;
            --secondary-blue: #ACD2FF;
            --dark-blue: #86BBF9;
            --light-bg: #E8F4FF;
            --white: #FFFFFF;
        }
        
        body {
            background-color: var(--light-bg) !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            padding-top: 20px;
        }
        
        .navbar-furniture {
            background-color: var(--primary-blue) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .btn-furniture {
            background-color: var(--secondary-blue) !important;
            border: none !important;
            color: #000 !important;
            font-weight: 500 !important;
            padding: 8px 20px !important;
            border-radius: 8px !important;
        }
        
        .btn-furniture:hover {
            background-color: var(--dark-blue) !important;
        }
        
        .product-card {
            background-color: var(--white) !important;
            border-radius: 12px !important;
            border: 1.5px solid #000 !important;
            padding: 20px !important;
            margin-bottom: 25px !important;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
            transition: transform 0.3s !important;
        }
        
        .product-card:hover {
            transform: translateY(-5px) !important;
        }
        
        .navbar-brand {
            font-weight: bold !important;
            font-size: 1.5rem !important;
        }
        
        h2 {
            color: #333 !important;
            margin-bottom: 20px !important;
        }
        
        .alert-success {
            background-color: #d4edda !important;
            border-color: #c3e6cb !important;
            color: #155724 !important;
        }
    </style>
</head>
<body>
    <!-- Header/Navbar -->
    <nav class="navbar navbar-expand-lg navbar-furniture">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="fas fa-chair"></i> A Mitra Furniture
            </a>
            <div class="navbar-nav">
                <a class="nav-link fw-bold" href="/">Home</a>
                <a class="nav-link fw-bold" href="/cart">Keranjang</a>
                <a class="nav-link fw-bold" href="/profile">Profil</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>