<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
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
            'balance' => ['required' , 'numeric', 'regex:/^\d{1,13}(\.\d{1,2})?$/', 'min:0.01'], 
        ];
    }

    public function prepareForValidation()
    {
        if($this->has('balance')) {
            $this->merge([
                'balance' => str_replace(['.', ','], ['', '.'], $this->balance)
            ]);
        }
    }
}
