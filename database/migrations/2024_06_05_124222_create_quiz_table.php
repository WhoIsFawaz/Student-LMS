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
        Schema::create('quiz', function (Blueprint $table) {
            $table->bigIncrements('quiz_id');
            $table->unsignedBigInteger('module_id');
            $table->string('quiz_title', 255);
            $table->text('quiz_description')->nullable();
            $table->timestamp('quiz_date');
            $table->integer('duration')->default(60); // Duration in minutes
            $table->timestamps();

            $table->foreign('module_id')->references('module_id')->on('modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz');
    }
};