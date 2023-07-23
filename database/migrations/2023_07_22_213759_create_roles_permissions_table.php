<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatesRoles_permissionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('roles_id');
            $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');
            $table->unsignedBigInteger('permissions_id');
            $table->foreign('permisions_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_permissions');
    }
};
