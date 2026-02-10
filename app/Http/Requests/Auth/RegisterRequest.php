<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; 
    }

    /**
     *
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255|regex:/^[\pL]+(\s[\pL]+){1,2}$/u',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|min:5|max:20|unique:users,phone|regex:/^\+?\d+$/',
            'image' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif,webp',
            'country' => 'required|string|size:2',
            'password' => 'required|string|min:8|max:255|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
        ];
    }



    public function messages(): array
    {
        return [
            // Name
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a valid string.',
            'name.min' => 'Name must be at least 3 characters long.',
            'name.max' => 'Name must not exceed 255 characters.',
            'name.regex' => 'Name must contain 2 or 3 words, letters only.',

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

            // Image
            'image.image' => 'Uploaded file must be an image.',
            'image.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif, webp.',
            'image.max' => 'Image must not exceed 2MB.',

            // Country
            'country.required' => 'Country code is required.',
            'country.string' => 'Country code must be a valid string.',
            'country.size' => 'Country code must be exactly 2 characters.',

            // Password
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a valid string.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.max' => 'Password must not exceed 255 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must include uppercase, lowercase, numbers, and symbols.',
        ];
    }
}
