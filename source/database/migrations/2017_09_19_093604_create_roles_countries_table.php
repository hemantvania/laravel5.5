<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_countries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('roleId')->unsigned();
			$table->foreign('roleId')->references('id')->on('userroles');
            $table->integer('countires')->unsigned();
			// $table->foreign('roleId')->references('id')->on('classes');
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
        Schema::dropIfExists('roles_countries');
    }
}
