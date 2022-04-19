<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuoteBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('operator_id');
            $table->integer('booking_id');
            $table->string('amount')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('quote_bookings');
    }
}
