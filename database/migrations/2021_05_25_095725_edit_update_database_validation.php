<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditUpdateDatabaseValidation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data', function (Blueprint $table) {
            $table->dropUnique(['P_NUMBER', 'phone', 'email']);
            $table->dropIndex(['P_NUMBER', 'phone', 'email']);
            $table->string('unique');
            $table->Unique(['unique', 'phone', 'email']);
            $table->Index(['unique', 'phone', 'email']);
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
            $table->Unique(['P_NUMBER', 'phone', 'email']);
            $table->Index(['P_NUMBER', 'phone', 'email']);
            $table->dropColumn('unique');
            $table->dropUnique(['unique', 'phone', 'email']);
            $table->dropIndex(['unique', 'phone', 'email']);
        });
    }
}
