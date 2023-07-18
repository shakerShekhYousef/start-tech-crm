<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('developer')->nullable(true);
            $table->string('community_location')->nullable(true);
            $table->string('building_name')->nullable(true);
            $table->string('property_name')->nullable(true);
            $table->string('unit_number')->nullable(true);
            $table->string('plot_area')->nullable(true);
            $table->string('customer_name')->nullable(true);
            $table->string('email_address')->nullable(true);
            $table->string('mobile')->nullable(true);
            $table->string('comments')->nullable(true);
            $table->string('status')->nullable(true);
            $table->string('nationality')->nullable(true);
            $table->string('property_type')->nullable(true);
            $table->string('furniture')->nullable(true);
            $table->string('floor_plans_view')->nullable(true);
            $table->string('bedrooms')->nullable(true);
            $table->string('customer_type')->nullable(true);
            $table->string('can_add')->nullable(true);
            $table->string('unite_price')->nullable(true);
            $table->string('roi')->nullable(true);
            $table->string('telephone_number')->nullable(true);
            $table->string('telephone_residence')->nullable(true);
            $table->string('telephone_office')->nullable(true);
            $table->string('general')->nullable(true);
            $table->string('property_finder_link')->nullable(true);
            $table->string('buyut_link')->nullable(true);
            $table->string('dubizzle_link')->nullable(true);
            $table->string('wow_propties_link')->nullable(true);
            $table->string('other_links')->nullable(true);
            $table->string('type_of_apt')->nullable(true);
            $table->string('property_size')->nullable(true);
            $table->string('floors')->nullable(true);
            $table->string('service_charge')->nullable(true);
            $table->string('payment_plan')->nullable(true);
            $table->string('rent')->nullable(true);
            $table->string('ready_off')->nullable(true);
            $table->string('handover')->nullable(true);
            $table->string('price_aed')->nullable(true);
            $table->string('bathrooms')->nullable(true);
            $table->string('completion')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
