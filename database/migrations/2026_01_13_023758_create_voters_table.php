<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            // ইউনিক ইনডেক্স সরিয়ে দিয়ে সাধারণ ইনডেক্স করা হয়েছে
            $table->string('voter_no', 20)->index(); 
            $table->string('area_no', 15)->index();
            
            $table->string('serial', 15)->nullable();
            $table->string('gender', 10)->nullable();
            
            $table->string('name');
            $table->string('father')->nullable();
            $table->string('mother')->nullable();
            $table->string('dob', 30)->nullable();
            $table->string('occupation')->nullable();
            $table->text('address')->nullable();

            $table->string('union_municipality')->nullable();
            $table->string('ward', 10)->nullable();
            $table->string('area_name')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voters');
    }
}
