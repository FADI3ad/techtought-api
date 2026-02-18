<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{

    public function index()
    {
        $subCategories = SubCategory::select(['id', 'slug', 'name'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'SubCategories retrieved successfully',
            'data' => [
                "subcategories" => $subCategories
            ],
            'meta' => [
                'total' => $subCategories->count()
            ]
        ], 200);
    }
    public function store(StoreSubCategoryRequest $request)
    {
        $subCategory = SubCategory::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'SubCategory created successfully',
            'data' => [
                "Subcategory" => [
                    "id" => $subCategory->id,
                    "name" => $subCategory->name,
                    "slug" => $subCategory->slug,
                    "category" => $subCategory->category->name
                ]
            ]
        ], 201);
    }

    public function show(SubCategory $subcategory)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'SubCategory retrieved successfully',
            'data' => [
                "SubCategory" => [
                    "id" => $subcategory->id,
                    "name" => $subcategory->name,
                    "slug" => $subcategory->slug,
                    "category" => $subcategory->category->name
                ]
            ]
        ], 200);
    }

    public function update(SubCategory $subCategory, UpdateSubCategoryRequest $request)
    {
        $subCategory->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'SubCategory updated successfully',
            'data' => [
                "Subcategory" => [
                    "id" => $subCategory->id,
                    "name" => $subCategory->name,
                    "slug" => $subCategory->slug,
                    "category" => $subCategory->category->name
                ]
            ]
        ], 201);
    }


    public function destroy(SubCategory $subcategory)
    {

        $subcategory->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully'
        ], 200);
    }

    public function showWithCourses(SubCategory $subcategory)
    {
        $subcategory->load([
            'courses:id,sub_category_id,slug,title'
        ]);


        return response()->json([
            'status' => 'success',
            'message' => 'SubCategory retrieved successfully',
            'data' => [
                "subcategory" => [
                    "id" => $subcategory->id,
                    "slug" => $subcategory->slug,
                    "name" => $subcategory->name,
                    "courses" => $subcategory->courses,
                    'meta' => [
                        'total courses' => $subcategory->courses->count()
                    ]
                ]
            ]
        ], 200);
    }
}
