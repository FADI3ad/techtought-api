<?php

namespace App\Http\Requests\instructor;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstructorRequest extends FormRequest
{
 
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:100|regex:/^[\pL\s]+$/u',
            'email' => 'required|string|email|max:255|unique:instructor_account_requests,email',
            'phone' => 'required|string|min:5|max:20|unique:instructor_account_requests,phone|regex:/^\+?\d+$/',
            'country' => 'required|string|max:100',
            'age' => 'required|integer|min:18|max:100',
            'cv_link' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:5120',
            'national_id_front_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'national_id_back_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'experience_years' => 'required|integer|min:0|max:50',
        ];
    }


    public function messages(): array
    {
        return [

            // Name
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a valid string.',
            'name.min' => 'Name must be at least 3 characters long.',
            'name.max' => 'Name must not exceed 100 characters.',
            'name.regex' => 'Name must contain letters only.',

            // Email
            'email.required' => 'Email is required.',
            'email.string' => 'Email must be a valid string.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'This email is already taken.',

            // Phone
            'phone.required' => 'Phone number is required.',
            'phone.string' => 'Phone number must be a valid string.',
            'phone.min' => 'Phone number is too short.',
            'phone.max' => 'Phone number is too long.',
            'phone.regex' => 'Phone number must contain only numbers and may start with +.',
            'phone.unique' => 'This phone number is already taken.',

            // Country
            'country.required' => 'Country is required.',
            'country.string' => 'Country must be a valid string.',
            'country.max' => 'Country must not exceed 100 characters.',

            // Age
            'age.required' => 'Age is required.',
            'age.integer' => 'Age must be an integer.',
            'age.min' => 'Age must be at least 18.',
            'age.max' => 'Age must not exceed 100.',

            // CV
            'cv_link.required' => 'CV file is required.',
            'cv_link.file' => 'CV must be a valid file.',
            'cv_link.mimes' => 'CV must be a file of type: jpeg, png, jpg, gif, svg, or pdf.',
            'cv_link.max' => 'CV file size must not exceed 5MB.',

            // National ID Front Image
            'national_id_front_image.required' => 'Front image of national ID is required.',
            'national_id_front_image.image' => 'Front ID file must be an image.',
            'national_id_front_image.mimes' => 'Allowed formats: jpeg, png, jpg, gif, svg.',
            'national_id_front_image.max' => 'Front ID image size must not exceed 2MB.',

            // National ID Back Image
            'national_id_back_image.required' => 'Back image of national ID is required.',
            'national_id_back_image.image' => 'Back ID file must be an image.',
            'national_id_back_image.mimes' => 'Allowed formats: jpeg, png, jpg, gif, svg.',
            'national_id_back_image.max' => 'Back ID image size must not exceed 2MB.',

            // Experience Years
            'experience_years.required' => 'Experience years are required.',
            'experience_years.integer' => 'Experience years must be an integer.',
            'experience_years.min' => 'Experience years must be at least 0.',
            'experience_years.max' => 'Experience years must not exceed 50.',

        ];
    }
}
