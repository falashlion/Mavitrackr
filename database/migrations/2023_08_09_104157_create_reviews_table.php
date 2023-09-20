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
        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table-> string('form_name');
            $table-> uuid('user_id');
            $table-> string('status');
            $table->dateTime('duedate_author');
            $table->dateTime('duedate_manager');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
        Schema::dropIfExists('reviews');
    }
};
