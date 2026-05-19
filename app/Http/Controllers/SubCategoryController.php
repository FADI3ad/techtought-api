<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreSubCategoryRequest;
use App\Http\Requests\Category\UpdateSubCategoryRequest;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    //-------------------------------------------------
    // Tested and working fine (for admin)
    //--------------------------------------------------
    public function index()
    {
        $subCategories = SubCategory::with('category:id,name,slug')
            ->select(['id', 'slug', 'name', 'category_id'])
            ->get();
        return response()->json([
            'status' => 'success',
            'message' => 'SubCategories retrieved successfully',
            'data' => [
                'subcategories' => $subCategories
            ],
            'meta' => [
                'total' => $subCategories->count()
            ]
        ], 200);
    }

    //-------------------------------------------------
    // Tested and working fine (for admin only)
    //--------------------------------------------------
    public function store(StoreSubCategoryRequest $request)
    {
        $subCategory = SubCategory::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'SubCategory created successfully',
            'data' => [
                'Subcategory' => [
                    'id' => $subCategory->id,
                    'name' => $subCategory->name,
                    'slug' => $subCategory->slug,
                    'category' => $subCategory->category->name
                ]
            ]
        ], 201);
    }

    //-------------------------------------------------
    // Tested and working fine (for admin)
    //--------------------------------------------------
    public function show(SubCategory $subcategory)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'SubCategory retrieved successfully',
            'data' => [
                'SubCategory' => [
                    'id' => $subcategory->id,
                    'name' => $subcategory->name,
                    'slug' => $subcategory->slug,
                    'category' => $subcategory->category->name
                ]
            ]
        ], 200);
    }

    // for admin
    public function update(SubCategory $subcategory, UpdateSubCategoryRequest $request)
    {
        $subcategory->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'SubCategory updated successfully',
            'data' => [
                'Subcategory' => [
                    'id' => $subcategory->id,
                    'name' => $subcategory->name,
                    'slug' => $subcategory->slug,
                    'category' => $subcategory->category->name
                ]
            ]
        ], 201);
    }

    //-------------------------------------------------
    // Tested and working fine (for admin only)
    //--------------------------------------------------
    public function destroy(SubCategory $subcategory)
    {
        $subcategory->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'SubCategory deleted successfully'
        ], 200);
    }

    public function showWithCourses(SubCategory $subcategory)
    {
        $subcategory->load([
            'courses.instructor'
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'SubCategory retrieved successfully',
            'data' => [
                'subcategory' => [
                    'id' => $subcategory->id,
                    'slug' => $subcategory->slug,
                    'name' => $subcategory->name,
                    'courses' => $subcategory->courses,
                    'meta' => [
                        'total courses' => $subcategory->courses->count()
                    ]
                ]
            ]
        ], 200);
    }
}
