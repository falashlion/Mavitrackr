<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CreateReviewRequest extends FormRequest
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

            'form_name' => 'string',
            'status' => 'string|in:Pending,Completed,Approved',
            'author_dueDate' => 'date',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'code'=> 422,
                'locale'=> 'en',
                'message'=> 'Invalid request',
                'data'=>$validator->errors()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }

        parent::failedValidation($validator);
    }
}
