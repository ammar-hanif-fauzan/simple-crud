<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormInputRequest extends FormRequest
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
            'text' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8',
            'checkbox' => 'nullable|array',
            'checkbox.*' => 'nullable|string',
            'radio' => 'required|string|max:255',
            'select' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'textarea' => 'required|string',
            'date' => 'required|date',
            'number' => 'required|integer',
            'range' => 'required|integer',
            'color' => 'required|string|max:7',
        ];
    }
}
