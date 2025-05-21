<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('products')->get();
        return response()->json($orders);
    }
    public function show(Order $order)
    {
        return response()->json($order->load('product'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1',
            'order_date' => 'required|date',
            'status' => 'in:new,completed',
            'customer_comment' => 'nullable',
        ]);


        $order = Order::create($validated);
        return response()->json($order, 201);
    }
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name' => 'required',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1',
            'order_date' => 'required|date',
            'status' => 'in:new,completed',
            'customer_comment' => 'nullable',
        ]);

        $order->update($validated);
        return response()->json($order);
    }
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }

    public function complete(Order $order)
    {
        $order->status = 'completed';
        $order->save();
        return response()->json($order);
    }
}
