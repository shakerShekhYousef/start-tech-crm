<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsenquirycustomerForBooktablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booktables', function (Blueprint $table) {
            $table->boolean('is_enquiry_customer')->default(false);
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
            $table->dropColumn('is_enquiry_customer');
        });
    }
}
