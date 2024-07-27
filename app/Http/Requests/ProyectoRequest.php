<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyectoRequest extends FormRequest
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
    public function rules()
    {
        return [
            'codigo_proyecto' => [
                'required',
                function ($attribute, $value, $fail) {
                    $patron = "/^\d{3}-\d{4}$/";

                    if (!preg_match($patron, $value)) {
                        $fail('El código del proyecto no tiene el formato válido. El formato correcto es 123-4567');
                    }
                }
            ],
            'empresa' => 'required',
            'fecha_entrega' => 'required|date|after_or_equal:today',
            'estatus' => 'required',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'codigo_proyecto.required' => 'El código del proyecto es obligatorio.',
            'fecha_entrega.required' => 'La fecha de entrega es obligatoria.',
            'fecha_entrega.date' => 'La fecha de entrega debe ser una fecha válida.',
            'fecha_entrega.after_or_equal' => 'La fecha de entrega no puede ser anterior a la fecha actual.',
            'imagen.image' => 'El archivo subido debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe tener uno de los siguientes formatos: jpeg, png, jpg, gif, svg.',
            'imagen.max' => 'La imagen no puede tener un tamaño mayor a 2 MB.',
        ];
    }
}
