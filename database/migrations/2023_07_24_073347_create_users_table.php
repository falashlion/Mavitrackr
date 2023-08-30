<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

 class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_matricule')->unique();
            $table->string('password');
            $table->string('profile_image')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->unique();
            $table->string('address')->nullable();
            $table->enum('gender', ['Male','Female'])->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->uuid('departments_id')->nullable();
            $table->uuid('line_manager')->nullable();
            $table->uuid('positions_id')->nullable();
            $table->foreignUuid('line_manager')->references('id')->on('users');
            $table->foreignUuid('departments_id')->references('id')->on('departments');
            $table->foreignUuid('positions_id')->references('id')->on('positions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
