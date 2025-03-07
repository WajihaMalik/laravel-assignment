<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Requests\FeedbackRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Intervention\Image\Laravel\Facades\Image;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::all();
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('actions', function ($product) {
                    return '
                        <a href="' . route('products.edit', $product->id) . '" class="btn btn-primary btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm delete-product" data-id="' . $product->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('products.index');
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }
    public function store(StoreProductRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'stock_quantity' => $request->stock_quantity,
            'stock_status' => $request->stock_status,
        ]);

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        if ($request->hasFile('images')) {
            $imagePaths = [];

            $productsPath = storage_path('app/public/products');
            if (!file_exists($productsPath)) {
                mkdir($productsPath, 0777, true);
            }
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $img = Image::read($image)
                ->resize(700, 700, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(storage_path('app/public/products/' . $imageName));
                $imagePaths[] = 'products/' . $imageName;
            }

            $product->images()->createMany(array_map(function ($imagePath) {
                return ['image_path' => $imagePath];
            }, $imagePaths));
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
                'category' => $product
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $selectedCategories = $product->categories->pluck('id')->toArray();
        $productImages = $product->images;

        return view('products.edit', compact('product', 'categories', 'selectedCategories', 'productImages'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'stock_quantity' => $request->stock_quantity,
            'stock_status' => $request->stock_status,
        ]);

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $img = Image::read($image)
                ->resize(700, 700, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(storage_path('app/public/products/' . $imageName));
                $imagePaths[] = 'products/' . $imageName;
            }

            $product->images()->delete();
            $product->images()->createMany(array_map(function ($imagePath) {
                return ['image_path' => $imagePath];
            }, $imagePaths));
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!',
                'category' => $product
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully!'], 200);
    }

    public function show($id)
    {
        $product = Product::with(['categories', 'images'])->findOrFail($id);
        return view('products.product-detail', compact('product'));
    }

    public function feedback(FeedbackRequest $request, $id)
    {
        Feedback::create([
            'product_id' => $id,
            'user_id' => auth()->id(),
            'comment' => $request->comment ?? null,
            'rating' => $request->rating,
        ]);

        return redirect()->route('product.show', $id)->with('success', 'Feedback submitted successfully.');
    }
}
