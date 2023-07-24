<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

 class  CreateKpasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kpas', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->unsignedBigInteger('strategic_domains_id');
                $table->timestamps();
                $table->foreign('strategic_domains_id')->references('id')->on('strategic_domains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpas');
    }
};
