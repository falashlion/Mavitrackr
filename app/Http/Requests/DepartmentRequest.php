<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as ApiResponseBuilder;
use Illuminate\Http\Exceptions\HttpResponseException;
class DepartmentRequest extends FormRequest
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
            'id'=> 'string',
            'title' => 'required|string',
            'manager_id'=> 'exists:users,id',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $response = ApiResponseBuilder::error(400);
        throw new HttpResponseException($response);
    }
}
