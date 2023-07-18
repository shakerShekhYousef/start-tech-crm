<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditTablesWonDeadFollowupBooktable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dead_leads', function (Blueprint $table) {
            $table->integer('previous_state')->default(0);
            $table->integer('previous_state_id')->default(0);
        });
        Schema::table('follow_up_leads', function (Blueprint $table) {
            $table->integer('previous_state')->default(0);
            $table->integer('previous_state_id')->default(0);
        });
        Schema::table('won_leads', function (Blueprint $table) {
            $table->integer('previous_state')->default(0);
            $table->integer('previous_state_id')->default(0);
        });
        Schema::table('booktables', function (Blueprint $table) {
            $table->integer('previous_state')->default(0);
            $table->integer('previous_state_id')->default(0);
        });
        Schema::table('qualified_leads', function (Blueprint $table) {
            $table->integer('previous_state')->default(0);
            $table->integer('previous_state_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dead_leads', function (Blueprint $table) {
            $table->dropColumn('previous_state');
            $table->dropColumn('previous_state_id');
        });
        Schema::table('follow_up_leads', function (Blueprint $table) {
            $table->dropColumn('previous_state');
            $table->dropColumn('previous_state_id');
        });
        Schema::table('won_leads', function (Blueprint $table) {
            $table->dropColumn('previous_state');
            $table->dropColumn('previous_state_id');
        });
        Schema::table('booktables', function (Blueprint $table) {
            $table->dropColumn('previous_state');
            $table->dropColumn('previous_state_id');
        });
        Schema::table('qualified_leads', function (Blueprint $table) {
            $table->dropColumn('previous_state');
            $table->dropColumn('previous_state_id');
        });
    }
}
