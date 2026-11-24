<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $primaryKey = 'categoria_id';

    public $timestamps = false;

    protected $fillable = [
        'categoria_nombre',
        'dias_max_prestamo',
        'eliminado_en',
    ];

    protected $casts = [
        'eliminado_en' => 'datetime',
    ];

    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class, 'id_categoria', 'categoria_id');
    }
}
