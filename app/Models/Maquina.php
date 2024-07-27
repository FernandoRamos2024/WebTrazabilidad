<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Maquina
 *
 * @property $id
 * @property $nombre
 * @property $estatus
 * @property $id_area
 * @property $created_at
 * @property $updated_at
 *
 * @property Area $area
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Maquina extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'estatus', 'id_area'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area');
    }
    
}
