<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userId')->unsigned()->nullable();
            $table->foreign('userId')->references('id')->on('users');
            $table->string("phone", 50)->nullable();
            $table->string("profileimage")->nullable();
            $table->string("addressline1")->nullable();
            $table->string("addressline2")->nullable();
            $table->string("city",50)->nullable();
            $table->string("state",50)->nullable();
            $table->string("zip",50)->nullable();
            $table->integer('country')->unsigned();
            $table->string('ssn')->nullable();
            $table->smallInteger('gender');
            $table->integer('default_school')->unsigned()->nullable();
            $table->foreign('default_school')->references('id')->on('schools');
            $table->boolean('enable_share_screen')->default(false);
            $table->softDeletes();
            $table->timestamps();
            $table->string('wilmaIp')->nullable();
            $table->string('wilmaToken')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_metas');
    }
}
