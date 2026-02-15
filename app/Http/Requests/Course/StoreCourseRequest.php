<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get validation rules.
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:150',
                Rule::unique('courses', 'title'),
            ],

            'description' => [
                'required',
                'string',
                'min:10',
            ],

            'image_path' => [
                'nullable',
                'string',
                'max:255',
            ],

            'lang' => [
                'required',
                Rule::in(['AR', 'EN']),
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'requirements' => [
                'nullable',
                'string',
                'min:5',
            ],

            'is_free' => [
                'required',
                'boolean',
            ],

            'sub_category_id' => [
                'required',
                'integer',
                'exists:sub_categories,id',
            ],
        ];
    }

    public function messages()
    {
        return [

            // title
            'title.required' => 'Course title is required.',
            'title.string'   => 'Course title must be valid text.',
            'title.min'      => 'Course title must be at least 3 characters.',
            'title.max'      => 'Course title must not exceed 150 characters.',
            'title.unique'   => 'This Course already exists.',

            // description
            'description.required' => 'Course description is required.',
            'description.string'   => 'Course description must be valid text.',
            'description.min'      => 'Course description must be at least 10 characters.',

            // image
            'image_path.string' => 'Image path must be valid text.',
            'image_path.max'    => 'Image path must not exceed 255 characters.',

            // lang
            'lang.required' => 'Language is required.',
            'lang.in'       => 'Language must be either AR or EN.',

            // price
            'price.required' => 'Price is required.',
            'price.numeric'  => 'Price must be a valid number.',
            'price.min'      => 'Price cannot be negative.',

            // requirements
            'requirements.string' => 'Requirements must be valid text.',
            'requirements.min'    => 'Requirements must be at least 5 characters.',

            // is_free
            'is_free.required' => 'Free status is required.',
            'is_free.boolean'  => 'Free status must be true or false.',

            // sub category
            'sub_category_id.required' => 'SubCategory is required.',
            'sub_category_id.integer'  => 'SubCategory ID must be a valid number.',
            'sub_category_id.exists'   => 'Selected SubCategory does not exist.',
        ];
    }
}
