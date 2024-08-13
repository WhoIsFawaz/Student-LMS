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
        Schema::create('assignments', function (Blueprint $table) {
            $table->bigIncrements('assignment_id');
            $table->unsignedBigInteger('module_id');
            $table->string('title', 100);
            $table->string('weightage', 100);
            $table->text('description')->nullable();
            $table->date('due_date');
            $table->string('file_path')->nullable();
            $table->timestamps();

            $table->foreign('module_id')->references('module_id')->on('modules')->onDelete('cascade');
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->index('module_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
