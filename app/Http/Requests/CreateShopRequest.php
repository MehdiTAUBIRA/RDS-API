<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateShopRequest extends FormRequest
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
            'siret' => 'required|unique:shop,siret',
            'shop_name' => 'required',
            'contactname',
            'phone' => 'required',
            'shop_name' => 'required',
            'telecopy',
            'email' => 'required',
            'user_id',
            'category' => 'required',
            'label',
            'address' => 'required',
            'city' => 'required',
            'postalcode' => 'required',
            'country' => 'required',
            'gps_x' => 'required',
            'gps_y' => 'required',

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
}
