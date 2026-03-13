<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
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
        // получаем ID клиента из URL, если это update
        $clientId = $this->route('client')?->id;

        return [
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('clients', 'email')->ignore($clientId),],
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ];
    }
}
