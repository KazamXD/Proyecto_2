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
    Schema::create('solicitudes', function (Blueprint $table) {
        $table->increments('id_solicitud');                  // INT PK AUTO_INCREMENT
        $table->unsignedInteger('usuario_id');               // INT NOT NULL
        $table->timestamp('fecha_solicitud')->useCurrent();  // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        $table->dateTime('fecha_inicio');                    // DATETIME NOT NULL
        $table->dateTime('fecha_fin');                       // DATETIME NOT NULL
        $table->enum('estado', ['pendiente', 'aprobada', 'rechazada', 'cancelada'])
              ->default('pendiente');                        // ENUM NOT NULL DEFAULT 'pendiente'
        $table->unsignedInteger('revisado_por')->nullable(); // INT NULL
        $table->timestamp('fecha_revision')->nullable();     // TIMESTAMP NULL DEFAULT NULL
        $table->string('motivo_rechazo', 255)->nullable();   // VARCHAR(255) NULL

        // FKs
        $table->foreign('usuario_id')
              ->references('id')
              ->on('usuarios');                              // sin acción = RESTRICT

        $table->foreign('revisado_por')
              ->references('id')
              ->on('usuarios');                              // sin acción = RESTRICT
    });
}

public function down(): void
{
    Schema::dropIfExists('solicitudes');
}
};
