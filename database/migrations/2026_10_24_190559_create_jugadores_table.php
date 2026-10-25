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
    Schema::create('jugadores', function (Blueprint $table) {
        $table->id();
        $table->foreignId('equipo_id')->constrained('equipos')->cascadeOnDelete();
        $table->string('nombre', 100);
        $table->unsignedTinyInteger('dorsal');
        $table->string('posicion', 20);
        $table->unsignedSmallInteger('estatura_cm')->nullable();
        $table->timestamps();

        // Un dorsal solo se puede repetir en equipos distintos
        $table->unique(['equipo_id', 'dorsal']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jugadores');
    }
};
