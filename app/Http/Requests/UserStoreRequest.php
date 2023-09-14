<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return
        [
            'user_matricule' => 'required|unique:users|string|max:255',
            'password'=>'required|string|min:8|',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,bmp,tiff|max:5048',
            'phone' =>'numeric',
            'address' =>'string',
            'gender'=> 'string',
            'departments_id'=> 'exists:departments,id',
            'positions_id'=> 'exists:positions,id',
            'roles'=> 'required|exists:roles,name',
            'line_manager' => 'exists:users,id'
        ];
    }

    public function messages(){
        return [
            'user_matricule.required' => 'The name field is required.',
            'user_matricule.string' => 'The name field must be a string.',
            'user_matricule.max' => 'The name field must not exceed 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email address is already in use.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password field must be a string.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];

    }
}
