<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // for admin
    public function index()
    {
        $categories = Category::select(['id', 'slug', 'name'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Categories retrieved successfully',
            'data'=> new CategoryCollection($categories)
        ], 200);
    }

    // for admin
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('categories', 'public');
        }

        $category = Category::create($data);

        Cache::forget('navbar_categories');

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'data' => new CategoryResource($category)
        ], 201);
    }

    // for admin and frontend
    public function show(Category $category)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Category retrieved successfully',
            'data' => new CategoryResource($category)
        ], 200);
    }

    // for admin
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        if ($request->hasFile('image_path')) {

            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('categories', 'public');
        }

        $category->update($data);

        Cache::forget('navbar_categories');

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
            'data' => new CategoryResource($category)
        ], 200);
    }

    // for admin
    public function destroy(Category $category)
    {

        if ($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }
        $category->delete();

        Cache::forget('navbar_categories');

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully'
        ], 200);
    }

    // for frontend
    public function navbarCategories()
    {
        $categories = Cache::remember('navbar_categories', 86400, function () {
            return Category::select(['slug', 'name'])->get();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Categories retrieved successfully',
            'data' => [
                "categories" => $categories,
                'meta' => [
                    'total' => $categories->count()
                ]
            ]
        ]);
    }

    // for frontend
    public function showWithSubcategories(Category $category)
    {
        $category->load(['subCategories:category_id,slug,name']);
        return response()->json([
            'status' => 'success',
            'message' => "Category and its subcategories retrieved successfully",
            'data' => [
                "category" => [
                    "slug" => $category->slug,
                    "name" => $category->name,
                    "description" => $category->description,
                    "image" => $category->image_path ? asset('storage/' . $category->image_path) : null,
                    "subcategories" => $category->subCategories,
                    'meta' => [
                        'total subcategories' => $category->subCategories->count()
                    ]
                ]
            ]
        ], 200);
    }
}
