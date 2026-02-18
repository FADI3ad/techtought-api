<?php

namespace App\Http\Requests\Section;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSectionRequest extends FormRequest
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
                'max:150',
                Rule::unique('sections', 'name'),
            ],

            'slug' => [
                'required',
                'string',
                'max:150',
                Rule::unique('sections', 'slug'),
            ],

            'course_id' => [
                'required',
                'integer',
                'exists:courses,id',
            ],
        ];
    }

    public function messages()
    {
        return [

            // name
            'name.required' => 'Section name is required.',
            'name.string'   => 'Section name must be valid text.',
            'name.min'      => 'Section name must be at least 3 characters.',
            'name.max'      => 'Section name must not exceed 150 characters.',
            'name.unique'   => 'This Section already exists.',

            // slug
            'slug.required' => 'Slug is required.',
            'slug.string'   => 'Slug must be valid text.',
            'slug.max'      => 'Slug must not exceed 150 characters.',
            'slug.unique'   => 'This slug is already taken.',

            // course
            'course_id.required' => 'Course is required.',
            'course_id.integer'  => 'Course ID must be a valid number.',
            'course_id.exists'   => 'Selected Course does not exist.',
        ];
    }
}



