<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstructorRequest extends FormRequest
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
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:instructor_requests,email',
            'country' => 'required|string|max:100',
            'subject' => 'required|string|max:150',
            'age' => 'required|integer|min:18',
            'phone' => 'required|string|max:20',
            'experience_years' => 'required|integer|min:0',
            'cv' => 'required|mimes:pdf|max:2048',
            'national_id_front' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'national_id_back' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
    public function messages()
{
    return [
        'fullname.required' => 'Full name is required.',
        'fullname.max' => 'Full name must not exceed 255 characters.',

        'email.required' => 'Email is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email has already submitted a request.',

        'country.required' => 'Country is required.',

        'subject.required' => 'Subject is required.',

        'age.required' => 'Age is required.',
        'age.integer' => 'Age must be a number.',
        'age.min' => 'You must be at least 18 years old.',

        'phone.required' => 'Phone number is required.',

        'experience_years.required' => 'Experience years is required.',
        'experience_years.integer' => 'Experience years must be a number.',

        'cv.required' => 'CV file is required.',
        'cv.mimes' => 'CV must be a PDF file.',
        'cv.max' => 'CV file size must not exceed 2MB.',

        'national_id_front.required' => 'Front ID image is required.',
        'national_id_front.image' => 'Front ID must be an image.',
        'national_id_front.mimes' => 'Front ID must be jpg, jpeg, or png.',

        'national_id_back.required' => 'Back ID image is required.',
        'national_id_back.image' => 'Back ID must be an image.',
        'national_id_back.mimes' => 'Back ID must be jpg, jpeg, or png.',
    ];
}
}
        
    

