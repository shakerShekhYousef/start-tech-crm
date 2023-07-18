<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditBooktableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booktables', function (Blueprint $table) {
            $table->string('phone')->nullable(true)->change();
            $table->string('email')->nullable(true)->change();
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
            $table->string('phone')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
        });
    }
}
