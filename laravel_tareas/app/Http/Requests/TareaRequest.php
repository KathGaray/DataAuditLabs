<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TareaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'estado'      => ['required', 'in:pendiente,completada'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El campo título es obligatorio.',
            'titulo.max'      => 'El campo título no puede superar 255 caracteres.',
            'estado.required' => 'El campo estado es obligatorio.',
            'estado.in'       => 'El estado debe ser pendiente o completada.',
        ];
    }
}
