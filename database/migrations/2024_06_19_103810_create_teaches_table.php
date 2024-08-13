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
        Schema::create('teaches', function (Blueprint $table) {
            $table->id('teaches_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('module_id');
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('module_id')->references('module_id')->on('modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teaches');
    }
};
