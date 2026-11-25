<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestamos extends Model
{
    protected $table = 'prestamos';
    protected $primaryKey = 'prestamo_id';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'prestamo_id', 'usuario_id', 'operador_id', 'fecha_entrega', 'fecha_limite', 'fecha_devolucion',
        'estado'
    ];

    protected $casts = [
        'fecha_entrega'    => 'datetime',
        'fecha_limite'     => 'datetime',
        'fecha_devolucion' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }

    public function operador()
    {
        return $this-> belongsTo(Usuario::class, 'operador_id', 'id');
    }
}
