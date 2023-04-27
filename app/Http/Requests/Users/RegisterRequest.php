<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\Person;

class RegisterRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:20|regex:/^([^0-9]*)$/',
            'email' => 'required|email:filter|unique:users',
            'password' => 'required|regex:/^(?=.*[a-z]{1,})(?=.*[A-Z]{1,})(?=.*[0-9]{1,})(?=.*[¿?!@#\$%\^&\*]{1,}).{10,}$/',
            'repeatPassword' => 'required|same:password',
            'aboutYou' => 'nullable|min:20|max:250',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // generic messages
            'required' => 'El campo :attribute es obligatorio',
            'min' => 'El campo :attribute debe tener como mínimo :min caracteres',
            'max' => 'El campo :attribute debe tener como máximo :max caracteres',
            'size' => 'El campo :attribute debe tener :size caracteres',
            'email' => 'El campo :attribute debe tener un formato de email válido',

            // message for specific fields
            'name.regex' => 'El campo nombre no admite números',
            'lastName.regex' => 'El campo apellidos no admite números',
            'dni.regex' => 'El campo dni debe tener el siguiente formato: 8 números seguidos de una letra EJ: 11111112L',
            'email.unique' => 'El campo email ya se encuentra registrado en la base de datos',
            'password.regex' => 'El campo contraseña debe cumplir con los siguientes requisitos: longitud mínima de 10 caracteres, contener al menos 1 número, 1 letra mayúscula, 1 letra minúscula y 1 carácter especial (EJ: ¿?!@#)',
            'repeatPassword.same' => 'El campo contraseña repetida debe coincidir con el campo contraseña',
            'phone.regex' => 'El campo teléfono debe contener solo números y opcionalmente el simbolo + para los prefijos de país',
            'iban.regex' => 'El campo iban debe cumplir el siguiente formato de IBAN: 2 letras del código ISO del país, 2 números de control IBAN, 4 números código del banco, 4 números código sucursal del banco, 2 números dígito de control, 10 números del número de cuenta (EJ: ES91 2100 0418 45 0200051332)',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'nombre',
            'lastName' => 'apellidos',
            'dni' => 'dni',
            'email' => 'email',
            'password' => 'contraseña',
            'repeatPassword' => 'contraseña repetida',
            'phone' => 'teléfono',
            'country' => 'país',
            'iban' => 'número de cuenta bancaria (IBAN)',
            'aboutYou' => 'sobre ti',
        ];
    }
}
