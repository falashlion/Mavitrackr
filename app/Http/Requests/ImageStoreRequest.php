<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as ApiResponseBuilder;
use Illuminate\Http\Exceptions\HttpResponseException;
class ImageStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            'profile_image'  => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $response = ApiResponseBuilder::error(400);
        throw new HttpResponseException($response);
    }
}
