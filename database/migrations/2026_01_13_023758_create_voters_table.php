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

            $table->index(['area_name', 'voter_no'], 'idx_area_voter');
            // ২. জেন্ডার ভিত্তিক ফিল্টারিং এর জন্য (যদি আপনি নারী/পুরুষ আলাদা করতে চান)
            $table->index(['area_name', 'gender', 'serial'], 'idx_area_gender_serial');
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
