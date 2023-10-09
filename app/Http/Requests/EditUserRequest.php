<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class EditUserRequest extends FormRequest
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
            'name' => 'Regex:/^[\D]+$/i|max:100|unique:users,name' . $user->id,
            'last_name' =>'Regex:/^[\D]+$/i|max:100',
            'first_name' => 'Regex:/^[\D]+$/i|max:100',
            'birthdate',
            'gender',
            'email' => 'email:rfc|max:255|unique:users,email' . $user->id,
            'telecopy',
            'phone' => 'phone|unique:users,phone' . $user->id,
            'password',
            'statut',

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
