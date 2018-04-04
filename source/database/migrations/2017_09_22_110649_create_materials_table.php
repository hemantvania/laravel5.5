<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('categoryId')->unsigned()->nullable();
            $table->foreign('categoryId')->references('id')->on('material_categories');
            $table->string('materialName');
            $table->text('description')->nullable();
            $table->string('link');
            $table->string('materialType');
            $table->integer('uploadBy');
            $table->string('materialIcon')->nullable();
            $table->tinyInteger('isDownloadable')->nullable()->comment('1: Downloadable; 2:online');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
