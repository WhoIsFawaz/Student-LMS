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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->bigIncrements('enrollment_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('module_id');
            $table->date('enrollment_date')->default(now());
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('module_id')->references('module_id')->on('modules')->onDelete('cascade');
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('module_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};