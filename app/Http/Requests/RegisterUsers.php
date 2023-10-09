<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterUsers extends FormRequest
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
        'name' => 'required|Regex:/^[\D]+$/i|unique:users,name|max:100',
        'last_name' => 'required|Regex:/^[\D]+$/i|max:100',
        'first_name' => 'required|Regex:/^[\D]+$/i|max:100',
        'birthdate' => 'required',
        'gender' => 'required',
        'email' => 'required|email:rfc|max:255|unique:users,email',
        'telecopy',
        'phone' => 'required|unique:users,phone',
        'address' => 'required',
        'city' => 'required',
        'postalcode' => 'required',
        'country' => 'required',
        'gps_x',
        'gps_y',
        'siren' => 'nullable|unique:users,siren',
        'password' => 'required',
        'statut' => 'required',
        'state',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'success' =>false,
            'status_code' => 422,
            'error'=>true,
            'message' => 'Erreur de Validation',
            'errorList' => $validator->errors()
        ]));
    }

    //public function message(){
        //return[
            //'name.required' => 'name doit etre fourni.',
            //'email.required' => 'Une adresse mail doit etre fourni',
            //'email.unique' => 'cette adresse mail existe déja',
            //'password.required' => 'un mot de passe est requis',
       // ];
    //}

    
}
