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
        Schema::create('prestamo_detalle', function(Blueprint $table){
            $table-> unsignedInteger('prestamo_id');
            $table-> unsignedInteger('equipo_id');
            $table-> unsignedInteger('cantidad')-> default(1);
            $table->primary(['prestamo_id', 'equipo_id']);

            //fk
            $table-> foreign('prestamo_id')-> references('id_prestamo')-> on('prestamos')->cascadeOnDelete();

            $table-> foreign('equipo_id')-> references('id_equipo')-> on('equipos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamo_detalle');
    }
};
