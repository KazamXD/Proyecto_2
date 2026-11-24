<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipo extends Model
{
    protected $table = 'equipos';

    protected $primaryKey = 'id_equipo';

    public $timestamps = false;

    protected $fillable = [
        'id_categoria',
        'codigo',
        'nombre_estado',
        'ruta_imagen',
        'eliminado_en',
    ];

    protected $casts = [
        'eliminado_en' => 'datetime',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(
            Categoria::class,
            'id_categoria',
            'categoria_id'
        );
    }
}
