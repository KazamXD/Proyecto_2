<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id('id_proveedor');

            $table->string('nombre', 150);
            $table->string('nombre_contacto', 100)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->text('direccion')->nullable();
            $table->text('informacion_general')->nullable();

            $table->timestamp('eliminado_en')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
