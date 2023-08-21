<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KpaRequest extends FormRequest
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
            'title' => 'required|string',
            'strategic_domains_id'=> 'exists:strategic_domains,id'
        ];
    }

    public function messages(){
        return[
            'title.*' =>'The title field must be a string.',

        ];
    }
}
