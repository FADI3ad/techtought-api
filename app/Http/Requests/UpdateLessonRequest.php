<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
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
            "section_id" => "required|exists:sections,id",
            "title" => "required|min:3|max:60|unique:sections,title," . $this->route('section')
        ];
    }

    public function messages(): array
    {
        return [
            'section_id.required' => 'Section is required.',
            'section_id.exists'   => 'The selected section does not exist.',

            'title.required' => 'Title is required.',
            'title.unique'   => 'This title has already been taken.',
            'title.min'      => 'Title must be at least 3 characters.',
            'title.max'      => 'Title may not be greater than 60 characters.'
        ];
    }
}
