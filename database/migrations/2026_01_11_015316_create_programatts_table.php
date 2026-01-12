<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramattsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programatts', function (Blueprint $table) {
            $table->id();
            $table->integer('program_id');
            $table->string('device_id');
            $table->string('attendee_name');
            $table->string('mobile');
            $table->timestamps();

            // এক ডিভাইস থেকে এক প্রোগ্রামে একবারই এন্ট্রি সম্ভব
            $table->unique(['program_id', 'device_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programatts');
    }
}
