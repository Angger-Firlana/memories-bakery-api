<?php

namespace App\Http\Delivery\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PutDeliveryRequest extends FormRequest
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
            'order_id' => 'sometimes|exists:orders,id',
            'courier_id' => 'sometimes|exist:couriers,id',
            'address' => 'sometimes|string|max:255',
            'fee'=> 'sometimes|integer|min:0',
            'delivery_date' => 'sometimes|date|after_or_equal:today',
            'status' => ['required', Rule::in(['pending', 'confirmation', 'to_ship', 'rejected','shipped'])],
        ];
    }
}
