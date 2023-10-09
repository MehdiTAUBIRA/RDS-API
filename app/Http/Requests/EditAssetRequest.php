<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class EditAssetRequest extends FormRequest
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
            'asset_url' => 'required|asset_url|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'asset_type' => 'required',
            'asset_source' => 'required',
           
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
            'asset_url.required' => 'une url doit etre fournie'
        ];
        
    }
}
