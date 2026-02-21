<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
      return[ 'content' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            'course_id' => [
                'required',
                'integer',
                'exists:courses,id',
            ]
      ];
    }
    
    public function messages()
    {
        return [
           
            //content
            'content.required'   => 'Content is required',
            'content.string'   => 'Content title must be valid text.',
            'content.min'        => 'Content must be at least 3 characters',
            'content.max'    => 'Content must not exceed 255 characters.',
             //course_id
            'course_id.required' => 'Course ID is required',
            'course_id.integer'  => 'Course ID must be a valid number.',
            'course_id.exists'   => 'This course does not exist',
        ];
    }
}
