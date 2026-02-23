<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:100|unique:categories,name|regex:/^[^\d]+$/',
            'description' => 'required|string|max:500',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages()
    {
        return [
            // name
            'name.required' => 'Category name is required.',
            'name.string' => 'Category name must be a string.',
            'name.min' => 'Category name must be at least 3 characters.',
            'name.max' => 'Category name must not exceed 100 characters.',
            'name.regex' => 'Category name must not contain numbers.',
            'name.unique' => 'Category name already exists.',

            // description
            'description.required' => 'Category description is required.',
            'description.string' => 'Category description must be a string.',
            'description.max' => 'Category description must not exceed 500 characters.',

            // image
            'image.required' => 'Category image is required.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'Allowed image formats: jpeg, png, jpg, gif, svg.',
            'image.max' => 'The image size must not exceed 2MB.',
        ];
    }
}
