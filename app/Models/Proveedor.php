<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $primaryKey = 'id_proveedor';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'nombre_contacto',
        'telefono',
        'email',
        'direccion',
        'informacion_general',
        'eliminado_en',
    ];

    protected $casts = [
        'eliminado_en' => 'datetime',
    ];
}
