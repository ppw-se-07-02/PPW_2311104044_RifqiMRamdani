<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    // Tambah ke keranjang dengan Raw SQL
    public function addToCartRawSQL(Request $request)
    {
        // Validasi: cek apakah produk sudah ada di keranjang user
        $existing = DB::select("SELECT * FROM carts 
                               WHERE user_id = ? AND product_id = ?", 
                               [$request->user_id, $request->product_id]);
        
        if (count($existing) > 0) {
            // Update quantity
            DB::update("UPDATE carts SET quantity = quantity + ? 
                       WHERE user_id = ? AND product_id = ?", 
                       [$request->quantity, $request->user_id, $request->product_id]);
        } else {
            // Insert baru
            DB::insert("INSERT INTO carts (user_id, product_id, quantity, created_at, updated_at) 
                       VALUES (?, ?, ?, NOW(), NOW())", 
                       [$request->user_id, $request->product_id, $request->quantity]);
        }
        
        return response()->json(['success' => true]);
    }
    
    // Tambah ke keranjang dengan Query Builder
    public function addToCartQueryBuilder(Request $request)
    {
        $existing = DB::table('carts')
            ->where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->first();
        
        if ($existing) {
            DB::table('carts')
                ->where('user_id', $request->user_id)
                ->where('product_id', $request->product_id)
                ->update(['quantity' => DB::raw('quantity + ' . $request->quantity)]);
        } else {
            DB::table('carts')->insert([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        return response()->json(['success' => true]);
    }
    
    // Tambah ke keranjang dengan Eloquent ORM
    public function addToCartEloquent(Request $request)
    {
        $cartItem = Cart::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->first();
        
        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }
        
        return response()->json(['success' => true]);
    }
}