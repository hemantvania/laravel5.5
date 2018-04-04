<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Addlanguagefield extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_metas', function (Blueprint $table) {
            $table->string('language')->nullable();
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->string('language')->nullable()->after('schoolType');
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->string('language')->nullable()->after('isDownloadable');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('language');
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('language');
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->string('language');
        });
    }
}
