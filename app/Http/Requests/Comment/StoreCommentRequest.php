<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_id' => ['required', 'exists:courses,id'],
            'comment' => ['required', 'string', 'min:3'],
        ];
    }

    public function messages(): array
    {
        return [
            'course_id.required' => 'Course is required.',
            'course_id.exists' => 'Selected course does not exist.',
            'comment.required' => 'Comment is required.',
            'comment.string' => 'Comment must be valid text.',
            'comment.min' => 'Comment must be at least 3 characters.',
        ];
    }
}
