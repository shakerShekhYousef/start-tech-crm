<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWonLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('won_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('title')->nullable(true);
            $table->integer('number_of_beds')->nullable(true);
            $table->string('comment')->nullable(true);
            $table->string('project')->nullable(true);
            $table->string('source')->nullable(true);
            $table->double('data_id')->nullable(true);
            $table->integer('created_by')->nullable(true);
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
        Schema::dropIfExists('won_leads');
    }
}
