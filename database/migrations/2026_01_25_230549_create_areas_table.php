<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40);
            $table->string('code', 6)->index();
            $table->string('word_no', 4);
            $table->foreignId('council_id')->nullable()->constrained('councils')->onDelete('set null');
            $table->unsignedSmallInteger('sub_district_id')->nullable();
            $table->unsignedSmallInteger('district_id')->nullable();
            $table->unsignedSmallInteger('constituency_id');
            $table->unsignedSmallInteger('male')->default(0);
            $table->unsignedSmallInteger('migration_male')->default(0);
            $table->unsignedSmallInteger('female')->default(0);
            $table->unsignedSmallInteger('migration_female')->default(0);
            $table->unsignedSmallInteger('hijra')->default(0);
            $table->unsignedSmallInteger('migration_hijra')->default(0);
            $table->date('published')->nullable();
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
        Schema::dropIfExists('areas');
    }
}
