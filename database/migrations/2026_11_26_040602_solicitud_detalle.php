<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('solicitud_detalle', function (Blueprint $table) {
        $table->unsignedInteger('solicitud_id');   // INT NOT NULL
        $table->unsignedInteger('equipo_id');      // INT NOT NULL

        // PK compuesta
        $table->primary(['solicitud_id', 'equipo_id']);

        // FKs
        $table->foreign('solicitud_id')
              ->references('id_solicitud')
              ->on('solicitudes')
              ->cascadeOnDelete();                 // ON DELETE CASCADE

        $table->foreign('equipo_id')
              ->references('id_equipo')
              ->on('equipos');                     // sin acción = RESTRICT
    });
}

public function down(): void
{
    Schema::dropIfExists('solicitud_detalle');
}
};
