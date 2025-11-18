<?php

namespace App\Http\Order\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            'customer_id' => 'sometimes',
            'employee_id' => 'sometimes|integer|exists:employees,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:15',
            'order_date' => 'required|date',
            'address' => 'required|string|max:255',
            'status' => 'required|string|in:pending,completed,cancelled',
            'details' => 'required|array',
            'details.*.menu_id' => 'required|integer|exists:menus,id',
            'details.*.quantity' => 'required|integer',
        ];
    }
}
