<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_id' => ['required', 'exists:courses,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'min:3'],
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => 'Rating is required.',
            'rating.integer' => 'Rating must be an integer between 1 and 5.',
            'rating.min' => 'Rating must be at least 1.',
            'rating.max' => 'Rating must not exceed 5.',
            'comment.string' => 'Comment must be valid text.',
            'comment.min' => 'Comment must be at least 3 characters.',
        ];
    }
}
