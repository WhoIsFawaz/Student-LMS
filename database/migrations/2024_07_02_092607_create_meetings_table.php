<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id('meeting_id');
            $table->unsignedBigInteger('user_id'); // Foreign key
            $table->unsignedBigInteger('module_id'); // Foreign key
            $table->unsignedBigInteger('booked_by_user_id')->nullable();
            $table->date('meeting_date')->nullable();
            $table->string('timeslot')->nullable();
            $table->enum('status', ['vacant', 'booked'])->default('vacant');
            $table->timestamps();

            // Adding foreign key constraint
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('module_id')
            ->references('module_id')
            ->on('modules')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
}
