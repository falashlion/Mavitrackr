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
                $table->uuid('id')->primary();
                $table->string('title');
                $table->uuid('strategic_domains_id');
                $table->timestamps();
                $table->foreignUuid('strategic_domains_id')->references('id')->on('strategic_domains');
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
