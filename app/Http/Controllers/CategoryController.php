<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    //-------------------------------------------------
    // Tested and working fine (for admin)
    //--------------------------------------------------
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Categories retrieved successfully',
            'data' => new CategoryCollection($categories)
        ], 200);
    }

    //-------------------------------------------------
    // Tested and working fine (for admin only)
    //--------------------------------------------------
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

    //-------------------------------------------------
    // Tested and working fine (for admin)
    //--------------------------------------------------
    public function show(Category $category)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Category retrieved successfully',
            'data' => new CategoryResource($category)
        ], 200);
    }

    //-------------------------------------------------
    // Tested and working fine (for admin only)
    //--------------------------------------------------
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

    //-------------------------------------------------
    // Tested and working fine (for admin only)
    //--------------------------------------------------
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

    public function navbarCategories()
    {
        $categories = Cache::remember('navbar_categories', 86400, function () {
            return Category::select(['slug', 'name'])->get();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Categories retrieved successfully',
            'data' => [
                'categories' => $categories,
                'meta' => [
                    'total' => $categories->count()
                ]
            ]
        ]);
    }

    public function showWithLatestSixCourses(Category $category)
    {
        $category->load('latestCourses.instructor');

        $courses = $category->latestCourses->map(function ($course) {
            return [
                'id' => $course->id,
                'slug' => $course->slug,
                'title' => $course->title,
                'description' => $course->description,
                'image' => asset('storage/' . $course->image_path),
                'requirements' => $course->requirements,
                'language' => $course->lang,
                'is_free' => $course->is_free,
                'price' => $course->price,
                'is_enrolled' => $course->is_enrolled,
                'is_favorite' => $course->is_favorite,
                'instructor' => [
                    'name' => $course->instructor?->name,
                ],
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Category With Courses retrieved successfully',
            'data' => [
                'category' => [
                    'id' => $category->id,
                    'slug' => $category->slug,
                    'name' => $category->name,
                    'image' => $category->image_path ? asset('storage/' . $category->image_path) : null,
                    'courses' => $courses,
                    'meta' => [
                        'total courses' => $courses->count()
                    ]
                ]
            ]
        ], 200);
    }

    public function showWithAllCourses(Category $category)
    {
        $category->load('courses.instructor');

        $courses = $category->courses->map(function ($course) {
            $courseArray = $course->toArray();
            $courseArray['image'] = $course->image_path ? asset('storage/' . $course->image_path) : null;
            $courseArray['instructor'] = [
                'name' => $course->instructor?->name,
            ];
            return $courseArray;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Category With Courses retrieved successfully',
            'data' => [
                'category' => [
                    'id' => $category->id,
                    'slug' => $category->slug,
                    'name' => $category->name,
                    'image' => $category->image_path ? asset('storage/' . $category->image_path) : null,
                    'courses' => $courses,
                    'meta' => [
                        'total courses' => $courses->count()
                    ]
                ]
            ]
        ], 200);
    }

    public function showWithSubcategories(Category $category)
    {
        $category->load(['subCategories:category_id,slug,name']);
        return response()->json([
            'status' => 'success',
            'message' => 'Category and its subcategories retrieved successfully',
            'data' => [
                'category' => [
                    'slug' => $category->slug,
                    'name' => $category->name,
                    'description' => $category->description,
                    'image' => $category->image_path ? asset('storage/' . $category->image_path) : null,
                    'subcategories' => $category->subCategories,
                    'meta' => [
                        'total subcategories' => $category->subCategories->count()
                    ]
                ]
            ]
        ], 200);
    }
}
