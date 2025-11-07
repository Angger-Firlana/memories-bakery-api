<?php

namespace App\Http\Manager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManagerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $managerId = $this->route('manager');
        $userId = optional($this->manager)->user_id;

        return [
            'branch_id' => 'required|exists:branchs,id',
            'fullname' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',

            // user info update
            'username' => 'required|string|max:50|unique:users,username,' . $userId,
            'email' => 'required|email|max:100|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:6|confirmed',
        ];
    }
}
