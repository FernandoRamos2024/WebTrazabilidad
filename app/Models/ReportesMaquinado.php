<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class ReportesMaquinado
 *
 * @property $id
 * @property $codigo_proyecto
 * @property $codigo_partida
 * @property $fecha
 * @property $hora
 * @property $turno
 * @property $accion
 * @property $estatus
 * @property $revision
 * @property $tiempo_total
 * @property $id_area
 * @property $id_maquina
 * @property $id_operador
 * @property $created_at
 * @property $updated_at
 *
 * @property Area $area
 * @property Maquina $maquina
 * @property Operadore $operadore
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ReportesMaquinado extends Model
{
    protected $table = 'reportes_maquinado';
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['codigo_proyecto', 'codigo_partida', 'fecha', 'hora', 'turno', 'accion', 'estatus', 'revision', 'tiempo_total', 'id_area', 'id_maquina', 'id_operador'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area() {
        return $this->belongsTo(Area::class, 'id_area');
    }
    
    public function maquina() {
        return $this->belongsTo(Maquina::class, 'id_maquina');
    }
    
    public function operador() {
        return $this->belongsTo(Operador::class, 'id_operador');
    }
    
}
