<?php

namespace App\Http\Courier\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_id' => 'required|exists:branchs,id',
            'fullname' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',

            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
