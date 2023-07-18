<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataStatusColumnForTablesQualifiedFollowupBooktable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data', function (Blueprint $table) {
            $table->boolean('assigned')->default(false);
        });
        Schema::table('follow_up_leads', function (Blueprint $table) {
             $table->boolean('assigned')->default(false);
        });
        Schema::table('booktables', function (Blueprint $table) {
             $table->boolean('assigned')->default(false);
        });
        Schema::table('qualified_leads', function (Blueprint $table) {
             $table->boolean('assigned')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data', function (Blueprint $table) {
            $table->dropColumn('assigned');
        });
        Schema::table('follow_up_leads', function (Blueprint $table) {
            $table->dropColumn('assigned');
        });
        Schema::table('booktables', function (Blueprint $table) {
            $table->dropColumn('assigned');
        });
        Schema::table('qualified_leads', function (Blueprint $table) {
            $table->dropColumn('assigned');
        });
    }
}
