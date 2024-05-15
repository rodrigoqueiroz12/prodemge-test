<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonRequest extends FormRequest
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
            'name' => ['required', 'between:3,255'],
            'alternate_name' => ['required', 'between:3,255'],
            'document' => ['required', 'size:14'],
            'father_name' => [],
            'mother_name' => [],
            'phone' => ['required'],
            'email' => ['required', 'email'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.between' => 'O campo nome deve ter entre 3 e 255 caracteres.',
            'alternate_name.required' => 'O campo nome alternativo é obrigatório.',
            'alternate_name.between' => 'O campo nome alternativo deve ter entre 3 e 255 caracteres.',
            'document.required' => 'O campo documento é obrigatório.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
        ];
    }
}
