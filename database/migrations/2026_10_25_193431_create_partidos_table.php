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
    Schema::create('partidos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('equipo_local_id')->constrained('equipos')->cascadeOnDelete();
        $table->foreignId('equipo_visitante_id')->constrained('equipos')->cascadeOnDelete();
        $table->dateTime('fecha_hora');
        $table->string('estado', 20)->default('programado'); // programado o finalizado
        $table->unsignedSmallInteger('puntos_local')->nullable();
        $table->unsignedSmallInteger('puntos_visitante')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidos');
    }
};
