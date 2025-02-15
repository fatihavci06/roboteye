<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

 

    /**
     * Customize the failed validation response.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return \Illuminate\Http\Response
     */
    protected function failedValidation($validator)
    {
        // JSON formatında custom response döndürme
        $response = [
            'status' => 'error',
            'message' => 'Validation Failed',
            'errors' => $validator->errors(),
        ];

        throw new \Illuminate\Validation\ValidationException($validator, response()->json($response, 422));
    }
}
