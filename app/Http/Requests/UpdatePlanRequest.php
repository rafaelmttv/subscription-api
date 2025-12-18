<?php

namespace App\Http\Requests;

use App\Enums\PlanStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlanRequest extends FormRequest
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
            'name' => ['sometimes', 'string'],
            'monthly_price' => ['sometimes', 'numeric', 'min:0'],
            'order_limit' => ['sometimes', 'integer', 'min:1'],
            'status' => ['sometimes', Rule::in(PlanStatus::cases())],
        ];
    }

}
