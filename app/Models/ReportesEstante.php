<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ReportesEstante
 *
 * @property $id
 * @property $codigo_proyecto
 * @property $codigo_partida
 * @property $fecha
 * @property $hora
 * @property $accion
 * @property $tiempo_total
 * @property $estatus
 * @property $revision
 * @property $id_estante
 * @property $created_at
 * @property $updated_at
 *
 * @property Estante $estante
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ReportesEstante extends Model
{
    protected $table = 'reportes_estante';
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['codigo_proyecto', 'codigo_partida', 'fecha', 'hora', 'accion', 'tiempo_total', 'estatus', 'revision', 'id_estante'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estante()
    {
        return $this->belongsTo(\App\Models\Estante::class, 'id_estante', 'id');
    }
    
}
