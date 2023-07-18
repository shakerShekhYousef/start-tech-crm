<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {     
        Schema::table('user_data', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->index()->change();
            $table->bigInteger('data_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('data_id')->references('id')->on('data')->onDelete('cascade');
        });

        Schema::table('user_data_comment', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->index()->change();
            $table->bigInteger('data_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('data_id')->references('id')->on('data')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_data', function (Blueprint $table) {
            //
        });
    }
}
