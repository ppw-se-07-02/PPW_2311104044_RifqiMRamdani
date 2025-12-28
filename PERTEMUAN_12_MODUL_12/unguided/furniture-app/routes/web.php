<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Route utama aplikasi furniture
Route::get('/', function () {
    return view('furniture.home');
});

Route::get('/cart', function () {
    return view('furniture.cart');
});

Route::get('/profile', function () {
    return view('furniture.profile');
});

// Route untuk testing database (Tugas 12.2)
Route::get('/test-raw-sql', function () {
    try {
        // Raw SQL Query
        $products = DB::select('SELECT * FROM products LIMIT 5');
        return response()->json([
            'method' => 'Raw SQL Query',
            'data' => $products
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});

Route::get('/test-query-builder', function () {
    try {
        // Query Builder
        $products = DB::table('products')->take(5)->get();
        return response()->json([
            'method' => 'Query Builder',
            'data' => $products
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});

Route::get('/test-eloquent', function () {
    try {
        // Eloquent ORM
        $products = App\Models\Product::take(5)->get();
        return response()->json([
            'method' => 'Eloquent ORM',
            'data' => $products
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});

// Route untuk insert data contoh (Tugas 12.2)
Route::get('/insert-raw', function () {
    $result = DB::insert("INSERT INTO products (name, price, category) VALUES (?, ?, ?)", 
        ['Kursi Kantor', 850000, 'kursi']
    );
    return response()->json(['success' => $result, 'method' => 'Raw SQL']);
});

Route::get('/insert-querybuilder', function () {
    $result = DB::table('products')->insert([
        'name' => 'Meja Kerja',
        'price' => 1250000,
        'category' => 'meja',
        'created_at' => now(),
        'updated_at' => now()
    ]);
    return response()->json(['success' => $result, 'method' => 'Query Builder']);
});

Route::get('/insert-eloquent', function () {
    $product = new App\Models\Product();
    $product->name = 'Sofa Minimalis';
    $product->price = 2950000;
    $product->category = 'sofa';
    $result = $product->save();
    
    return response()->json([
        'success' => $result, 
        'method' => 'Eloquent ORM',
        'id' => $product->id
    ]);
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Order routes
Route::get('/order/raw', [OrderController::class, 'createOrderRawSQL']);
Route::get('/order/querybuilder', [OrderController::class, 'createOrderQueryBuilder']);
Route::get('/order/eloquent', [OrderController::class, 'createOrderEloquent']);

// Product routes dari ProductController
Route::get('/product/raw', [ProductController::class, 'insertRawSQL']);
Route::get('/product/querybuilder', [ProductController::class, 'insertQueryBuilder']);
Route::get('/product/eloquent', [ProductController::class, 'insertEloquent']);