<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::select(['id', 'name', 'slug']);
            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('actions', function ($category) {
                    return '
                        <a href="' . route('categories.edit', $category->id) . '" class="btn btn-primary btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm delete-category" data-id="' . $category->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('categories.index');
    }

    public function create()
    {
        return view('categories.create');
    }
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category added successfully!',
                'category' => $category
            ]);
        }

        return redirect()->route('categories.index')->with('success', 'Category added successfully!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully!',
            ]);
        }

        return redirect()->route('categories.edit', $id)->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        // Find the category and delete it
        $category = Category::findOrFail($id);
        $category->delete();

        // Return success message as JSON
        return response()->json(['message' => 'Category deleted successfully!'], 200);
    }

    public function getCategories()
    {
        $categories = Category::all(); // Get all categories
        return view('categories.category-list', compact('categories'));
    }

    public function showCategories($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products;

        return view('products.products-list', compact('category', 'products'));
    }
}
