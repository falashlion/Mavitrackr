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
            $table->string('Password', 60);
            $table->rememberToken();
            $table->string('profile_image');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->unique();
            $table->string('adresse');
            $table->unsignedBigInteger('job_titles_id');
            $table->foreign('job_titles_id')->references('id')->on('job_titles')->onDelete('cascade');
            $table->enum('gender', ['Male','Female','Other']);
            $table->string('email')->unique();
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
