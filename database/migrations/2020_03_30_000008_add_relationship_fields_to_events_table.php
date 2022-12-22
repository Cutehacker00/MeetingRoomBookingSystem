<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEventsTable extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedInteger('room_id');
            $table->foreign('room_id', 'room_fk_1226840')->references('id')->on('rooms');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1226841')->references('id')->on('users');
        });

    }
}
