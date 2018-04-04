<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('className', 100);
            $table->integer('schoolId')->unsigned()->nullable();
            $table->foreign('schoolId')->references('id')->on('schools');
            $table->integer('educationTypeId')->unsigned()->nullable();
            $table->foreign('educationTypeId')->references('id')->on('education_types');
            $table->string('standard', 100);
            $table->integer('class_duration');
            $table->integer('class_size');
            $table->softDeletes();
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
        Schema::dropIfExists('classes');
    }
}
