<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditWorking_daysRequest extends FormRequest
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
            'days' => 'required',
            'open_hours' => 'required',
            'closing_hours' => 'required',
            'break_start' => 'required',
            'break_end' => 'required',
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

    public function messages(){
        return[
            'days.required' => 'un jour doit etre fourni'
        ];
    }
}
