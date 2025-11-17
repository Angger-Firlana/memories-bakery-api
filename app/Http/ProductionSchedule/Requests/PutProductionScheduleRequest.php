<?php

namespace App\Http\ProductionSchedule\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PutProductionScheduleRequest extends FormRequest
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
            'branch_id' => 'sometimes|integer|exists:branchs,id',
            'schedule_date' => 'sometimes|date',
            'status' => 'sometimes|string|in:pending,completed,cancelled',
            'details' => 'sometimes|array',
            'details.*.id' => 'sometimes|integer|exists:production_schedule_details,id',
            'details.*.menu_id' => 'required_with:details|integer|exists:menus,id',
            'details.*.quantity' => 'required_with:details|integer|min:1',
        ];
    }
}
