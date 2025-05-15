<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Fetch all products
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    // Create a new product
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity'    => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|string',
        ]);

        $product = Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'quantity'    => $request->quantity,
            'price'       => $request->price,
            'image'       => $request->image,
        ]);

        return response()->json([
            'status'  => (bool) $product,
            'data'    => $product,
            'message' => $product ? 'Product Created!' : 'Error Creating Product',
        ]);
    }

    // Show a single product
    public function show(Product $product)
    {
        return response()->json($product, 200);
    }

    // Upload product image and return image URL
    public function uploadFile(Request $request)
    {
        if ($request->hasFile('image')) {
            $name = time() . "_" . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $name);

            return response()->json(['url' => asset("images/$name")], 201);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'sometimes|string|max:255',
            'description' => 'sometimes|nullable|string',
            'quantity'    => 'sometimes|integer|min:0',
            'price'       => 'sometimes|numeric|min:0',
            'image'       => 'sometimes|nullable|string',
        ]);

        $status = $product->update($request->only(['name', 'description', 'quantity', 'price', 'image']));

        return response()->json([
            'status'  => $status,
            'message' => $status ? 'Product Updated!' : 'Error Updating Product',
        ]);
    }

    // Add quantity to product
    public function quantity(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product->quantity += $request->get('quantity');
        $status = $product->save();

        return response()->json([
            'status'  => $status,
            'message' => $status ? 'Units Added!' : 'Error Adding Product Units',
        ]);
    }

    // Delete product
    public function destroy(Product $product)
    {
        $status = $product->delete();

        return response()->json([
            'status'  => $status,
            'message' => $status ? 'Product Deleted!' : 'Error Deleting Product',
        ]);
    }
}
