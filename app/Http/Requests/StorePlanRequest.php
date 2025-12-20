<?php

namespace App\Http\Requests;

use App\Enums\PlanStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlanRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'monthly_price' => ['required', 'numeric', 'min:0'],
            'order_limit' => ['required', 'integer', 'min:1'],
            'status' => ['required', Rule::in(PlanStatus::cases())],
        ];
    }

}
