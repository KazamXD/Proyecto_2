<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table = 'bitacora';
    protected $primaryKey = 'id';
    public $timestanmps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'usuario_id', 'accion', 'entidad', 'entidad_id',
        'valores_antes', 'valores_despues', 'ip', 'creado_en'
    ];

    protected $casts = [
        'valores_antes'   => 'array',
        'valores_despues' => 'array',
        'creado_en'       => 'datetime'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }
}
