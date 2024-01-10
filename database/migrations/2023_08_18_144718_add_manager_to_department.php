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
        Schema::table('departments', function (Blueprint $table) {
            $table->uuid('manager_id')->nullable();
            $table->foreign('manager_id')->references('id')->on('users');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropColumn('manager_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['departments_id']);
            $table->dropColumn('departments_id');

        });
        Schema::dropIfExists('departments');
    }
};
