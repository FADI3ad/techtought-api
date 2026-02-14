<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubCategoryRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[^\d]+$/',
                Rule::unique('sub_categories', 'name'),
            ],
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ]
        ];
    }



    public function messages()
    {
        return [
            // name
            'name.required' => 'SubCategory name is required when updating.',
            'name.string'   => 'SubCategory name must be valid text.',
            'name.min'      => 'SubCategory name must be at least 3 characters.',
            'name.max'      => 'SubCategory name must not exceed 100 characters.',
            'name.regex'    => 'SubCategory name must not contain numbers.',
            'name.unique'   => 'Another SubCategory with this name already exists.',

            // category
            'category_id.required' => 'Category is required when updating.',
            'category_id.integer'  => 'Category ID must be a valid number.',
            'category_id.exists'   => 'The selected Category does not exist.',
        ];
    }
}
