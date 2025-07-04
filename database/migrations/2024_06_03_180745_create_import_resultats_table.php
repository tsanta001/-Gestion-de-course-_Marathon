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
        Schema::create('importresultats', function (Blueprint $table) {
            $table->id();
            $table->integer('etape_rang');
            $table->integer('num_dossard');
            $table->string('coureur_nom');
            $table->string('genre');
            $table->date('ddn');
            $table->string('equipe_nom');
            $table->timestamp('arrivee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('importresultats');
    }
};
