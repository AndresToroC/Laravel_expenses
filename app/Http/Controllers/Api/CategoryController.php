<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;

class CategoryController extends Controller
{
    public function categories() {
        $categories = Category::all();

        return response()->json([
            'categories' => $categories
        ], 200);
    }

    public function subCategories(Request $request) {
        $category_id = $request->category_id;

        $subCaterogies = SubCategory::whereCategoryId($category_id)->get();

        return response()->json([
            'subCategories' => $subCaterogies
        ], 200);
    }
}
