<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonRequest extends FormRequest
{
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
            'document' => ['required'],
            'father_name' => [],
            'mother_name' => [],
            'phone' => ['required'],
            'email' => ['required', 'email'],

            // First Address

            'type' => ['required'],
            'zip_code' => ['required'],
            'street' => ['required'],
            'number' => ['required'],
            'complement' => [],
            'neighborhood' => ['required'],
            'state' => ['required'],
            'city' => ['required'],
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

            // First Address

            'type.required' => ['O campo tipo é obrigatório.'],
            'zip_code.required' => ['O campo CEP é obrigatório.'],
            'street.required' => ['O campo rua é obrigatório.'],
            'number.required' => ['O campo número é obrigatório.'],
            'complement' => [],
            'neighborhood' => ['O campo bairro é obrigatório.'],
            'state' => ['O campo estado é obrigatório.'],
            'city' => ['O campo cidade é obrigatório.'],
        ];
    }
}
