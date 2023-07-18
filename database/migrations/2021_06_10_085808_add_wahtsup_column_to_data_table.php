<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWahtsupColumnToDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data', function (Blueprint $table) {
            $table->string('phone_whatsup')->nullable();
            $table->string('MOBILE_whatsup')->nullable();
            $table->string('SECONDARY_MOBILE_wahtsup')->nullable();
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
            $table->dropColumn('phone_whatsup');
            $table->dropColumn('MOBILE_whatsup');
            $table->dropColumn('SECONDARY_MOBILE_wahtsup');
        });
    }
}
