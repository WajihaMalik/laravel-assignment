<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function getCategories(Request $request)
    {
        $categories = Category::paginate(10);

        return CategoryResource::collection($categories);
    }
}
