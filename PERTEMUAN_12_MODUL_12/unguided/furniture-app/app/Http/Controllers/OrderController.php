<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    // Raw SQL
    public function createOrderRawSQL(Request $request)
    {
        $orderNumber = 'ORD-' . time();
        
        DB::insert("INSERT INTO orders (order_number, user_id, total_amount, status, shipping_address) VALUES (?, ?, ?, ?, ?)", 
            [$orderNumber, $request->user_id, $request->total_amount, 'unpaid', $request->shipping_address]
        );
        
        $orderId = DB::getPdo()->lastInsertId();
        
        return response()->json([
            'success' => true,
            'order_id' => $orderId,
            'order_number' => $orderNumber,
            'method' => 'Raw SQL'
        ]);
    }
    
    // Query Builder
    public function createOrderQueryBuilder(Request $request)
    {
        $orderNumber = 'ORD-' . time();
        
        $orderId = DB::table('orders')->insertGetId([
            'order_number' => $orderNumber,
            'user_id' => $request->user_id,
            'total_amount' => $request->total_amount,
            'status' => 'unpaid',
            'shipping_address' => $request->shipping_address,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'order_id' => $orderId,
            'method' => 'Query Builder'
        ]);
    }
    
    // Eloquent ORM
    public function createOrderEloquent(Request $request)
    {
        $order = new Order();
        $order->order_number = 'ORD-' . time();
        $order->user_id = $request->user_id;
        $order->total_amount = $request->total_amount;
        $order->status = 'unpaid';
        $order->shipping_address = $request->shipping_address;
        $order->save();
        
        return response()->json([
            'success' => true,
            'order' => $order,
            'method' => 'Eloquent ORM'
        ]);
    }
}