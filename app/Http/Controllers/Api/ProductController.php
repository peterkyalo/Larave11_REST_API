<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::get();

        if ($products->count() > 0) {
            return ProductResource::collection($products);
        } else {
            return response()->json(['message' => 'No products found'], 404);
        }

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|decimal:2',
        ]);

        $product = Product::create($data);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => new ProductResource($product),
        ]);
    }

    public function show(Product $product)
    {
            return new ProductResource(resource: $product);

    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|decimal:2',
        ]);

        $product->update($data);

        return response()->json([
           'message' => 'Product updated successfully',
            'data' => new ProductResource($product),
        ]);
    }

    public function destroy(Product $product)
    {
            $product->delete();
            return response()->json([
                'message' => 'Product deleted successfully',
            ]);
        }
}
