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
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('title');
            $table->unsignedBigInteger('kpas_id');
            $table->unsignedBigInteger('users_id');
            $table->json('indicators')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->integer('weighted_average_score')->nullable();
            $table->integer('score')->nullable();
            $table->foreign('kpas_id')->references('id')->on('kpas')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
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
