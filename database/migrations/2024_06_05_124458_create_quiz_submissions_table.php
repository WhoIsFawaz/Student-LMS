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
        Schema::create('quiz_submissions', function (Blueprint $table) {
            $table->bigIncrements('quiz_submission_id');
            $table->unsignedBigInteger('quiz_questions_id');
            $table->unsignedBigInteger('user_id');
            $table->string('submission_answer', 500);
            $table->timestamps();

            $table->foreign('quiz_questions_id')->references('quiz_questions_id')->on('quiz_questions')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_submissions');
    }
};
