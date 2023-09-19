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
            $table->uuid('user_id');
            $table->json('indicators')->nullable();
            $table->integer('weight', 5, 2)->nullable();
            $table->integer('weighted_average_score')->nullable();
            $table->integer('score')->nullable();
            $table->foreign('kpas_id')->references('id')->on('kpas');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
