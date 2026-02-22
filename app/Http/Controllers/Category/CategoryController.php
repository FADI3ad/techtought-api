<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;



class CategoryController extends Controller
{


    public function index()
    {
        $categories = Category::select(['id', 'slug', 'name'])->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Categories retrieved successfully',
            'data' => [
                "categories" => $categories
            ],
            'meta' => [
                'total' => $categories->count()
            ]
        ], 200);
    }

    public function store(StoreCategoryRequest $request)
    {

        $category = Category::create($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'data' => [
                "category" => [
                    "id" => $category->id,
                    "slug" => $category->slug,
                    "name" => $category->name
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
                    "id" => $category->id,
                    "slug" => $category->slug,
                    "name" => $category->name
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
                    "id" => $category->id,
                    "slug" => $category->slug,
                    "name" => $category->name
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





    public function showWithSubcategories(Category $category)
    {
        $category->load(['subCategories:id,category_id,slug,name']);
        return response()->json([
            'status' => 'success',
            'message' => 'Category retrieved successfully',
            'data' => [
                "category" => [
                    "id" => $category->id,
                    "slug" => $category->slug,
                    "name" => $category->name,
                    "subcategories" => $category->subCategories,
                    'meta' => [
                        'total subcategories' => $category->subCategories->count()
                    ]
                ]
            ]
        ], 200);
    }

    public function showWithCourses(Category $category)
    {
        $category->load([
            'courses:id,category_id,slug,title'
        ]);


        return response()->json([
            'status' => 'success',
            'message' => 'Category retrieved successfully',
            'data' => [
                "Category" => [
                    "id" => $category->id,
                    "slug" => $category->slug,
                    "name"=>$category->name,
                    "courses" => $category->courses,
                    'meta' => [
                        'total courses' => $category->courses->count()
                    ]
                ]
            ]
        ], 200);
    }



}
