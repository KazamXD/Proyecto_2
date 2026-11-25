<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rol extends Model
{
    protected $table = 'rol';

    protected $primaryKey = 'id_rol';

    public $timestamps = false;

    protected $fillable = [
        'nombre_rol',
    ];

    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'rol_id', 'id_rol');
    }

    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(
            Permiso::class,
            'rol_permiso',
            'rol_id',
            'permiso_id',
            'id_rol',
            'id_permiso'
        );
    }
}
