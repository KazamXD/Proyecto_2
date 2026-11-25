<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrestamoDetalle extends Model
{
    protected $table = 'prestamo_detalle';
    public $incrementing = false;     // PK compuesta, no autoincremental
    public $timestamps = false;
    protected $primaryKey = null;     // Eloquent no maneja PK compuesta nativamente

    protected $fillable = ['prestamo_id', 'equipo_id', 'cantidad'];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'prestamo_id', 'id_prestamo');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id', 'id_equipo');
    }
}
