<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceBetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lottery_id' => 'required|uuid|exists:lotteries,id',
            'draw_id' => 'required|uuid|exists:draws,id',
            'numbers' => 'required|array|min:1',
            'numbers.*' => 'integer',
            'stake' => 'required|numeric|min:0.01',
        ];
    }
}
