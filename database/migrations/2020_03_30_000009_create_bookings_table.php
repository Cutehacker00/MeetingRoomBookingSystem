<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->longText('description')->nullable();
            $table->string('booking_status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }
}
