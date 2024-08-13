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
        Schema::create('grades', function (Blueprint $table) {
            $table->bigIncrements('grade_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('assignment_id');
            $table->string('grade', 10);
            $table->string('score', 10);
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('assignment_id')->references('assignment_id')->on('assignments')->onDelete('cascade');
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('assignment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
