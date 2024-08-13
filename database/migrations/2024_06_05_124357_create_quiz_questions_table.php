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
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->bigIncrements('quiz_questions_id');
            $table->unsignedBigInteger('quiz_id');
            $table->text('question');
            $table->string('option_a', 50);
            $table->string('option_b', 50);
            $table->string('option_c', 50);
            $table->string('option_d', 50);
            $table->string('correct_option', 1);
            $table->integer('marks');
            $table->timestamps();

            $table->foreign('quiz_id')->references('quiz_id')->on('quiz')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
