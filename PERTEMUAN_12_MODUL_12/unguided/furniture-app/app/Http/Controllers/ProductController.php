<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductController extends Controller
{
    // Method 1: Raw SQL
    public function insertRawSQL(Request $request)
    {
        $result = DB::insert("INSERT INTO products (name, price, category) VALUES (?, ?, ?)", 
            [$request->name, $request->price, $request->category]
        );
        
        return response()->json([
            'success' => $result,
            'message' => 'Data inserted using Raw SQL'
        ]);
    }
    
    // Method 2: Query Builder  
    public function insertQueryBuilder(Request $request)
    {
        $result = DB::table('products')->insert([
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        return response()->json([
            'success' => $result,
            'message' => 'Data inserted using Query Builder'
        ]);
    }
    
    // Method 3: Eloquent ORM
    public function insertEloquent(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category = $request->category;
        $result = $product->save();
        
        return response()->json([
            'success' => $result,
            'message' => 'Data inserted using Eloquent ORM',
            'product_id' => $product->id
        ]);
    }
}