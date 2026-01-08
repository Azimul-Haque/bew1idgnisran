<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // কর্মসূচির নাম
        $table->string('type'); // ধরন (জনসংযোগ, মিছিল ইত্যাদি)
        $table->string('organizer'); // আয়োজক
        $table->string('venue'); // সমাবেশের স্থান
        $table->text('map_link')->nullable(); // গুগল ম্যাপ লিংক
        $table->dateTime('program_date'); // তারিখ ও সময়
        $table->string('phone')->nullable(); // জরুরি যোগাযোগ নম্বর
        $table->text('info')->nullable(); // গুরুত্বপূর্ণ তথ্য
        $table->string('image')->nullable(); // পোস্টারের ইমেজ পাথ
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
        Schema::dropIfExists('programs');
    }
}
