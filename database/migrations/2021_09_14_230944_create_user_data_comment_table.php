<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDataCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_data_comment', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("data_id");
            $table->string('comment')->nullable(true);
            $table->string('userstatus')->nullable(true);
            $table->dateTime('appointment_date')->nullable(true);
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
        Schema::dropIfExists('user_data_comment');
    }
}
