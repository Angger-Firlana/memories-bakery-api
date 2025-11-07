<?php

namespace App\Http\Courier\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $courierId = $this->route('id');
        $userId = optional($this->courier)->user_id ?? null;

        return [
            'branch_id' => 'required|exists:branchs,id',
            'fullname' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',

            'username' => 'required|string|max:50|unique:users,username,' . $userId,
            'email' => 'required|email|max:100|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:6|confirmed',
        ];
    }
}
