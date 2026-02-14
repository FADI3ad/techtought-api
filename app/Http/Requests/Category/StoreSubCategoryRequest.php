<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubCategoryRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Determine if the user is authorized to make this request.
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
            ],
        ];
    }



    public function messages()
    {
        return [
            //name
            'name.required' => 'SubCategory name is required.',
            'name.string'   => 'SubCategory name must be valid text.',
            'name.min'      => 'SubCategory name must be at least 3 characters.',
            'name.max'      => 'SubCategory name must not exceed 100 characters.',
            'name.regex'    => 'SubCategory name must not contain numbers.',
            'name.unique'   => 'This SubCategory already exists.',


            //category
            'category_id.required' => 'Category is required.',
            'category_id.integer'  => 'Category ID must be a valid number.',
            'category_id.exists'   => 'Selected Category does not exist.',
        ];
    }
}
