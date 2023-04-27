<?php

namespace App\Http\Requests\Contracts;

use App\Models\Contract;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'status' => 'in:'.Contract::STATUS_ACTIVE.','.Contract::STATUS_FINALIZED.','.Contract::STATUS_ANNULLED,
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ];
    }
}
