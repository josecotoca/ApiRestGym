<?php

namespace App\Http\Requests\Instructors;

use App\Models\Instructor;
use App\Models\Person;
use Illuminate\Foundation\Http\FormRequest;

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
            'dni' => 'required|unique:people',
            'iban' => 'required',
            'gender' => 'in:'.Person::GENDER_MALE.','.Person::GENDER_FEMALE,
            'email' => 'required|email:filter|unique:users',
            'name' => 'required|min:2|max:75',
            'last_name' => 'required|min:2|max:100',
            'phone' => 'nullable|max:25',
            'address' => 'required|min:2|max:250',
            'country' => 'required|min:2|max:50',
            'birth_date' => 'nullable|date|before:-13 years',
            'speciality' => 'required|in:'.Instructor::SPECIALITY_BODYJUMP.','.Instructor::SPECIALITY_PERSONAL.','.Instructor::SPECIALITY_BODYATACK.','.Instructor::SPECIALITY_ZUMBA
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
            'dni' => 'dni',
            'iban' => 'número de cuenta bancaria (IBAN)',
            'gender' => 'género',
            'email' => 'correo electrónico',
            'name' => 'nombres',
            'last_name' => 'apellidos',
            'phone' => 'teléfono',
            'address' => 'dirección',
            'country' => 'país',
            'birth_date' => 'fecha de nacimiento',
            'speciality' => 'especialidad'
        ];
    }
}
