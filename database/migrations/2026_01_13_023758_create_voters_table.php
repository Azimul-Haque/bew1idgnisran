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
            $table->string('voter_id')->nullable();
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
            // ১. এরিয়া এবং জেন্ডার ফিল্টারিং দ্রুত করার জন্য কম্পোজিট ইনডেক্স
            $table->index(['area_id', 'gender']);

            // ২. যদি এরিয়া, সেন্টার এবং জেন্ডার—এই তিনটি দিয়েই ফিল্টার করেন
            $table->index(['area_id', 'center_id', 'gender']);

            // ৩. শুধু সেন্টার ভিত্তিক কুয়েরির জন্য
            $table->index('center_id');
            
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
