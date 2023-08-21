<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

 class CreateStrategicdomainsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('strategic_domains', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->enum('title', ['Financial', 'Customer', 'Process', 'People']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strategic_domains');
    }
};
