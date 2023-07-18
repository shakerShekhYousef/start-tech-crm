<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
          $table->string('serial_num')->nullable(true);
          $table->string('date_listed')->nullable(true);
          $table->string('agent_name')->nullable(true);
          $table->string('category')->nullable(true);
          $table->string('building_status')->nullable(true);
          $table->string('client_name')->nullable(true);
          $table->string('unit_for_sales')->nullable(true);
          $table->string('remarks')->nullable(true);
          $table->string('source_of_lead')->nullable(true);
          $table->string('specifications')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('serial_num');
            $table->dropColumn('date_listed');
            $table->dropColumn('agent_name');
            $table->dropColumn('category');
            $table->dropColumn('building_status');
            $table->dropColumn('client_name');
            $table->dropColumn('unit_for_sales');
            $table->dropColumn('remarks');
            $table->dropColumn('source_of_lead');
            $table->dropColumn('specifications');
          });
    }
}
