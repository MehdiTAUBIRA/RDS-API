<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LogUserRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'success' =>false,
            'error'=>true,
            'status_code' => 403,
            'status_message' => 'informations non valide.',
            'message' => 'Erreur de Validation',
            'errorList' => $validator->errors()
        ]));
    }

    public function messages()
    {
        return[
            'email.required' => 'un e_mail doit etre fourni',
            'email.email' => 'e_mail non valide',
            'email.exists' => 'cet e_mail n\'existe pas',
            'password.required' => 'un mot de passe doit etre fourni',
        ];
        
    }
}
