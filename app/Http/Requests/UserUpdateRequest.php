<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as ApiResponseBuilder;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserUpdateRequest extends FormRequest
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
                'user_matricule' => 'string|max:255',
                'password'=>'string|min:8|',
                'first_name' => 'string',
                'last_name' => 'string',
                'email' => 'email|unique:users',
                'profile_image' => 'image|mimes:jpg,png,jpeg,gif,svg,bmp,tiff|max:8048',
                'phone' =>'numeric',
                'address' =>'string',
                'gender'=> 'string',
                'departments_id'=> 'exists:departments,id',
                'positions_id'=> 'exists:positions,id',
                'roles'=> 'exists:roles,name',
                'line_manager'=> 'exists:users,id'
            ];

    }
    public function messages()
    {
        return [
            'email.unique' => 'The email address is already in use.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = ApiResponseBuilder::error(400);
        throw new HttpResponseException($response);
    }
}

