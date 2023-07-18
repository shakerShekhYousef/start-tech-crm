<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToBooktables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booktables', function (Blueprint $table) {
            $table->string('title')->nullable(true);
            $table->integer('number_of_beds')->nullable(true);
            $table->string('comment')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booktables', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('number_of_beds');
            $table->dropColumn('comment');
        });
    }
}
