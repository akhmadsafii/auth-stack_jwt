<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        if (request()->wantsJson()) {
            return response()->json(['products' => $products]);
        } else {
            return view('content.products.v_index', ['products' => $products]);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images');
            $validatedData['image'] = $imagePath;
        }

        $product = Product::create($validatedData);

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Product created successfully']);
        }
        return response()->json(['message' => 'Product created successfully', 'product' => $product]);
    }
}
