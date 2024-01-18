<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberStoreRequest extends FormRequest
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
            'first_name'   =>['required'],
            'middle_name'  =>['required'],
            'last_name'    =>['required'],
            'phone_number' =>['required','numeric','digits:12','unique:members,phone_number','unique:users,phone_number'],
            'email'        =>['required','unique:members,email','unique:users,email'],
            'dob'          =>['required'],
            'id_type_id'   =>['required'],
            'id_number'    =>['required'],
            'member_type'  =>['required'],
        ];
    }
}
