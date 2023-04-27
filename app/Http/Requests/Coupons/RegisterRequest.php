<?php

namespace App\Http\Requests\Coupons;

use App\Models\Coupon;
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
            'number_of_uses' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'in:'.Coupon::COUPON_TYPE_PROMO.','.Coupon::COUPON_TYPE_DISCOUNT
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
            'number_of_uses' => 'Cantidad de usos',
            'start_date' => 'Fecha inicio',
            'end_date' => 'Fecha fin',
            'type' => 'Tipo'
        ];
    }

}
