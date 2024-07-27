<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportesMaquinadoRequest extends FormRequest
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
			'turno' => 'required',
			'accion' => 'required',
			'estatus' => 'required',
			'id_area' => 'required',
			'id_maquina' => 'required',
			'id_operador' => 'required',
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
            'turno.required' => 'El turno es obligatorio.',
            'accion.required' => 'La acción es obligatoria.',
            'estatus.required' => 'El estatus es obligatorio.',
            'id_area.required' => 'El área es obligatorio.',
            'id_maquina.required' => 'La máquina es obligatoria.',
            'id_operador.required' => 'El operador es obligatorio.',
        ];
    }
}
