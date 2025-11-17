<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PutProductionRequests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'branch_id' => 'required|integer|exists:branchs,id',        
            'menu_id' => 'sometimes|integer|exists:menus,id',
            'quantity' => 'sometimes|integer|min:1',
            'dateProduction' => 'sometimes|date'
        ];
    }
}
