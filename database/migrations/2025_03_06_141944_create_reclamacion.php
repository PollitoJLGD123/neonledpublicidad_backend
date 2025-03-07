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
        Schema::create('reclamacion', function (Blueprint $table) {
            $table->id("id_reclamacion");
            $table->string("nombre", 100);
            $table->string("apellido", 100);
            $table->string("email", 100);
            $table->string("telefono", 20);
            $table->string("departamento", 100);
            $table->string("direccion", 100);
            $table->string("distrito", 100);
            $table->string("tipo_servicio", 100);
            $table->date("fecha_incidente");
            $table->decimal("monto_reclamado", 10, 2);
            $table->text("descripcion_servicio");
            $table->boolean("declaracion_veraz");
            $table->boolean("acepta_politica");
            $table->string("estado",50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reclamacion');
    }
};
