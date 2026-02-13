<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;


class CategoryController extends Controller
{
    public function index() {}




    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'data' => [
                "category" => [
                    "name" => $category->name,
                    "slug" => $category->slug
                ]
            ]
        ], 201);
    }

    public function show(Category $category)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Category retrieved successfully',
            'data' => [
                "category" => [
                    "name" => $category->name,
                    "slug" => $category->slug
                ]
            ]
        ], 200);
    }


    public function update(UpdateCategoryRequest $request, Category $category)
    {

        $category->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
            'data' => [
                'category' => [
                    'name' => $category->name,
                    'slug' => $category->slug,
                ]
            ]
        ], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully'
        ], 200);
    }
}
