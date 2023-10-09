<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class EditUser_addressRequest extends FormRequest
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
            'label' ,
            'address',
            'city',
            'postalcode',
            'country',
            'gps_x',
            'gps_y',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'success' =>false,
            'error'=>true,
            'message' => 'Erreur de Validation',
            'errorList' => $validator->errors()
        ]));
    }

    public function messages()
    {
        return[
            'label.required' => 'un titre doit etre fourni'
        ];
        
    }
}
