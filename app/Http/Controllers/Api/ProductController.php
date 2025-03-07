<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function getProducts(Request $request)
    {
        $products = Product::with(['categories', 'images'])->paginate(10);
        return ProductResource::collection($products);
    }
}
