<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    function __construct() {
        $this->middleware(['role:admin']);
    }
    
    public function index(Request $request, Category $category)
    {
        $searchSubCategory = ($request->searchSubCategory) ? $request->searchSubCategory : '';

        $subCategories = $category->subCategories()->where(function($q) use ($searchSubCategory) {
                if ($searchSubCategory) {
                    $q->where('name', 'LIKE', '%'.$searchSubCategory.'%');
                }
            })->paginate(20);
        
        return view('admin.categories.subCategories.index', compact('category', 'subCategories', 'searchSubCategory'));
    }

    public function create(Category $category)
    {
        return view('admin.categories.subCategories.create', compact('category'));
    }

    public function store(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|min:3|unique:sub_categories,name,NULL,id,category_id,'.$category->id
        ]);

        $category->subCategories()->saveMany([
            new SubCategory($request->all())
        ]);

        return redirect()->back()->with('message', 'Sub categoría creada correctamente');
    }

    public function show(Category $category, SubCategory $subCategory)
    {
        //
    }

    public function edit(Category $category, SubCategory $subCategory)
    {
        return view('admin.categories.subCategories.edit', compact('category', 'subCategory'));
    }

    public function update(Request $request, Category $category, SubCategory $subCategory)
    {
        $request->validate([
            'name' => 'required|max:255|min:3|unique:sub_categories,name,NULL,id,category_id,'.$category->id
        ]);

        $subCategory->update($request->all());

        return redirect()->back()->with('message', 'Sub categoría actualizada correctamente');
    }

    public function destroy(Category $category, SubCategory $subCategory)
    {
        $subCategory->delete();

        return redirect()->back()->with('message', 'Sub categoría eliminada correctamente');
    }
}
