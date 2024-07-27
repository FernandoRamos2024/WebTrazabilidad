<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportesEstanteRequest extends FormRequest
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
			'codigo_proyecto' => [
                'required',
                function ($attribute, $value, $fail) {
                    $patron = "/^\d{3}-\d{4}$/";

                    if (!preg_match($patron, $value)) {
                        $fail('El código del proyecto no tiene el formato válido. El formato correcto es 123-4567');
                    }
                }
            ],
			'codigo_partida' => [
                'required',
                function ($attribute, $value, $fail) {
                    $patron = "/^\d{3}-\d{4}-\d{2}\.\d{2}$/";

                    if (!preg_match($patron, $value)) {
                        $fail('El código de partida no tiene el formato válido. El formato correcto es 123-4567-89.12');
                    }
                }
            ],
			'fecha' => 'required',
			'hora' => 'required',
			'accion' => 'required',
			'estatus' => 'required',
			'id_estante' => 'required',
			'revision' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'codigo_proyecto.required' => 'El código del proyecto es obligatorio.',
            'codigo_partida.required' => 'El código de partida es obligatorio.',
            'fecha.required' => 'La fecha es obligatoria.',
            'hora.required' => 'La hora es obligatoria.',
            'accion.required' => 'La acción es obligatoria.',
            'estatus.required' => 'El estatus es obligatorio.',
            'id_estante.required' => 'El estante es obligatorio.',
        ];
    }
}
