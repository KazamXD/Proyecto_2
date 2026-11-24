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
        Schema::create('bitacora', function(Blueprint $table){
            $table -> bigIncrements('id');
            $table -> unsignedInteger('usuario_id')->nullable();
            $table -> string('accion');
            $table -> string('entidad');
            $table -> unsignedInteger('entidad_id');
            $table -> json('valores_antes')->nullable();
            $table -> json('valores_despues')->nullable();
            $table -> string('ip')->nullable();
            $table->timestamp('creado_en')->useCurrent();

            //fk
            $table-> foreign('usuario_id') -> references('id') -> on ('usuarios') -> nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora');
    }
};
