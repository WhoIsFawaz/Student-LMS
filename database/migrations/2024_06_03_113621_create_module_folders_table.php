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
        Schema::create('module_folders', function (Blueprint $table) {
            $table->bigIncrements('module_folder_id');
            $table->string('folder_name', 50);
            $table->unsignedBigInteger('module_id');
            $table->timestamps();

            $table->foreign('module_id')->references('module_id')->on('modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_folders');
    }
};
