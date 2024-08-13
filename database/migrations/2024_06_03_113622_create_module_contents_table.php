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
        Schema::create('module_contents', function (Blueprint $table) {
            $table->bigIncrements('content_id');
            $table->unsignedBigInteger('module_folder_id');
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->string('file_path', 255)->nullable();
            $table->timestamp('upload_date')->useCurrent();
            $table->timestamps();

            $table->foreign('module_folder_id')->references('module_folder_id')->on('module_folders')->onDelete('cascade');
        });

        Schema::table('module_contents', function (Blueprint $table) {
            $table->index('module_folder_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_contents');
    }
};