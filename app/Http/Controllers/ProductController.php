<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json($products);
    }
    public function show(Product $product)
    {
        return response()->json($product->load('category'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric|min:0',
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($validated);
        return response()->json($product);
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
