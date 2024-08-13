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
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->bigIncrements('assignment_submission_id');
            $table->unsignedBigInteger('assignment_id');
            $table->unsignedBigInteger('user_id');
            $table->string('submission_description', 500)->nullable();
            $table->json('submission_files'); 
            $table->timestamp('submission_date')->useCurrent();
            $table->string('grade')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->foreign('assignment_id')->references('assignment_id')->on('assignments')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};