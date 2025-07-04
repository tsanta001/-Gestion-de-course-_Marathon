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
        Schema::create('importetapes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->decimal('longueur');
            $table->integer('nbr_coureur');
            $table->integer('rang');
            $table->date('date_depart');
            $table->time('heure_depart');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('importetapes');
    }
};
