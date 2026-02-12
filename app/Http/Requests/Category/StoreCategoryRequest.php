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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:100|unique:categories,name|regex:/^[^\d]+$/',
        ];
    }



    public function messages()
    {
        return [
            //name
            'name.required' => 'Category name is required.',
            'name.string' => 'Category name must be a string.',
            'name.min' => 'Category name must be at least 3 characters.',
            'name.max' => 'Category name must not exceed 100 characters.',
            'name.regex' => 'Category name must not contain numbers.',
            'name.unique' => 'Category name already exists.',
            
        ];
    }
}
