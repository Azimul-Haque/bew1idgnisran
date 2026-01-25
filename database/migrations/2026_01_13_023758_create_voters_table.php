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
        // VoterList Migration (The Big Table)
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table->string('sl_no')->nullable();
            $table->string('name')->nullable();
            $table->string('voter_id')->nullable()->unique(); // ভোটার আইডি ইউনিক এবং ইনডেক্সড
            $table->string('father_name')->nullable();
            $table->string('husband_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('profession')->nullable();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            
            // Foreign Keys with Indexes
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->foreignId('center_id')->nullable()->constrained('centers')->onDelete('set null');
            
            // Composite index for ultra-fast filtering
            $table->index(['area_id', 'center_id']);
            $table->index(['voter_id', 'center_id', 'gender']);
            
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
