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
        Schema::create ('prestamos', function(Blueprint $table){
            $table->increments('id_prestamo');
            $table-> unsignedInteger('usuario_id');
            $table-> unsignedInteger('operador_id');
            $table->timestamp('fecha_entrega')->useCurrent();
            $table->dateTime('fecha_limite');
            $table->timestamp('fecha_devolucion')->nullable();
            $table-> enum('estado', ['prestado', 'devuelto', 'retrasado'])-> default('prestado');

            //fk
            $table-> foreign('usuario_id')-> references('id')-> on('usuarios');
            $table-> foreign('operador_id')-> references('id')-> on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
