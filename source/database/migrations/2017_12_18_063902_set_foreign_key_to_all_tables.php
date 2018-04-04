<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetForeignKeyToAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('userrole')->references('id')->on('userroles');
        });

       /* Schema::table('schools', function (Blueprint $table) {
            $table->foreign('country')->references('id')->on('countries');
        });*/

        Schema::table('user_metas', function (Blueprint $table) {
            $table->foreign('country')->references('id')->on('countries');
        });

        Schema::table('manage_edesks', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('users');
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('teacher_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table){
           $table->dropForeign('userrole');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_userrole_foreign');
        });
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeign('schools_country_foreign');
        });
        Schema::table('user_metas', function (Blueprint $table) {
            $table->dropForeign('user_metas_country_foreign');
        });
        Schema::table('manage_edesks', function (Blueprint $table) {
            $table->dropForeign('manage_edesks_student_id_foreign');
            $table->dropForeign('manage_edesks_class_id_foreign');
            $table->dropForeign('manage_edesks_teacher_id_foreign');
        });
    }
}
