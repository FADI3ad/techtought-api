<?php

namespace App\Http\Requests\lesson;


use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
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
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
            'video' => 'nullable|file|mimes:mp4,mov,avi|max:51200',
        ];
    }


    public function messages(): array
    {
        return [
            //section
            'section_id.required' => 'Section is required.',
            'section_id.exists'   => 'The selected section does not exist.',


            //title
            'title.required' => 'Title is required.',
            'title.unique'   => 'This title has already been taken.',
            'title.min'      => 'Title must be at least 3 characters.',
            'title.max'      => 'Title may not be greater than 60 characters.'
        ];
    }
}
