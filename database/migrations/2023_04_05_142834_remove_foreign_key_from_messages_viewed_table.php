<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveForeignKeyFromMessagesViewedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages_viewed', function (Blueprint $table) {
            $table->dropForeign('messages_viewed_message_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages_viewed', function (Blueprint $table) {
            $table->foreign('message_id')->references('id')->on('messages');
        });
    }
}
