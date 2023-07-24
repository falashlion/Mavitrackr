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
            $table->id();
            $table->string('user_matricule')->unique();
            $table->string('Password');
            $table->string('profile_image')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->unique();
            $table->string('address')->nullable();
            $table->boolean('is_manager')->default(false);
            $table->enum('gender', ['Male','Female']);
            $table->string('email')->unique();
            $table->unsignedBigInteger('departments_id');
            $table->unsignedBigInteger('positions_id');
            $table->foreign('departments_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('positions_id')->references('id')->on('positions')->onDelete('cascade');
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
