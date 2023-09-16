<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as ApiResponseBuilder;
use Illuminate\Http\Exceptions\HttpResponseException;

class RolesRequest extends FormRequest
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
        return [
                'name' => 'required|unique:roles,name',
                'permissions'=>'exists:permissions,name'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The role name is required.',
            'name.unique' => 'The role name must be unique.',
            'permissions.required' => 'At least one permission is required.',
            'permissions.array' => 'The permissions must be an array.',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $response = ApiResponseBuilder::error(400);
        throw new HttpResponseException($response);
    }
}
