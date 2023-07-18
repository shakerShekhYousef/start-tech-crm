<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditUserBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_books', function (Blueprint $table) {
            $table->unique(['user_id', 'book_id', 'comment']);
            $table->index(['user_id', 'book_id', 'comment']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_books', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'book_id', 'comment']);
            $table->dropIndex(['user_id', 'book_id', 'comment']);
        });
    }
}
