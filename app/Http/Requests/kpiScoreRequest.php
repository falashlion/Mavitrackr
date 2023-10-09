<?php

namespace App\Http\Requests;

use App\Models\Kpi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as ApiResponseBuilder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
class kpiScoreRequest extends FormRequest
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
    public function rules()
    {
        $kpi = Kpi::find($this->route('id'));

        $rules = [
            'score' => 'required|integer|max:4',
        ];
        if (!$kpi) {
            $rules['score'] .= '|nullable';
        } else {
            $weight = $kpi->weight;
            if (!$weight) {
                $rules['score'] .= '|nullable';
            } else {
                $rules['score'] .= "|numeric|min:0|max:$weight";
            }
        }
        return $rules;
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
