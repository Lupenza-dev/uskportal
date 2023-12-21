<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanStoreRequest extends FormRequest
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
            'uuid' =>'required',
            'amount'           =>'required',
            'bank_account_no'  =>'required',
            'payment_date'      =>'required',
            'payment_reference' =>['required','unique:payouts,payment_reference']
        ];
    }
}
