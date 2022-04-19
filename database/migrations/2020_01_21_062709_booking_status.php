<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BookingStatus extends Migration
{
    public function up()
    {
        Schema::create('booking_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('type'); // 1=Accept , 0=Reject
            $table->string('title');
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('booking_statuses');
    }
}
