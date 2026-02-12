<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;

class CategoryController extends Controller
{
    public function index() {}

    public function show() {}



    public function store(StoreCategoryRequest $request)
    {
        $name = $request->input('name');

        $category = Category::create([
            "name" => $name,
            "slug" => Str::slug($name, '-')
        ]);

        return response()->json([
            'status' => 'success',

            'message' => 'Category created successfully',

            'data' => [

                "category" => [
                    "name" => $category->name
                ]

            ]

        ], 201);
    }


    public function update() {}

    public function delete() {}
}
