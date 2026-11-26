<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';
    protected $primaryKey = 'id_solicitud';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id', 'fecha_solicitud', 'fecha_inicio', 'fecha_fin',
        'estado', 'revisado_por', 'fecha_revision', 'motivo_rechazo',
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_inicio'    => 'datetime',
        'fecha_fin'       => 'datetime',
        'fecha_revision'  => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }

    public function revisor()
    {
        return $this->belongsTo(Usuario::class, 'revisado_por', 'id');
    }

    public function equipos()
    {
        return $this->belongsToMany(
            Equipo::class,          // modelo relacionado
            'solicitud_detalle',    // tabla pivote
            'solicitud_id',         // FK de Solicitud en la pivote
            'equipo_id'             // FK de Equipo en la pivote
        );
    }
}
