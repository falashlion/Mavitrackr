<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

 class CreateKpisTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kpis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->uuid('kpas_id');
            $table->json('indicators')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->integer('weighted_average_score')->nullable();
            $table->integer('score')->nullable();
            $table->foreignUuid('kpas_id')->references('id')->on('kpas');
            $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpis');
    }
};
