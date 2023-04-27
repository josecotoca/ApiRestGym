<?php

namespace App\Http\Requests\Contracts;

use App\Models\Contract;
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
            'customer_id' => 'required|exists:customers,id',
            'coupon_id' => 'exists:coupons,id',
            'membership_id' => 'exists:memberships,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'amount_payment' => 'required|numeric'
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
            'customer_id' => 'Id Cliente',
            'coupon_id' => 'Id Cupon',
            'membership_id' => 'Membresía',
            'start_date' => 'Fecha inicio',
            'end_date' => 'Fecha fin',
            'amount_payment' => 'Monto pagado'
        ];
    }
}
