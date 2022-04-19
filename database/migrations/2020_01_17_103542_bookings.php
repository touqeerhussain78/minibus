<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Bookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('no_of_passengers');
            $table->date('pickup_date');
            $table->string('pickup_time');
            $table->string('pickup_address');
            $table->decimal('pickup_lat', 10,7);
            $table->decimal('pickup_long', 10,7);
            $table->date('return_date');
            $table->string('return_time');
            $table->decimal('return_lat', 10,7);
            $table->decimal('return_long', 10,7);
            $table->string('return_address');
            $table->decimal('dropoff_lat', 10,7);
            $table->decimal('dropoff_long', 10,7);
            $table->string('dropoff_address');
            $table->tinyInteger('is_return')->default(0)->nullable();
            $table->text('trip_reason');
            $table->string('hand_luggage');
            $table->string('mid_luggage');
            $table->string('large_luggage');
            $table->text('additional_info');
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->string('security_deposit');
            $table->string('trip_end_date')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->tinyInteger('is_refund')->default(0)->nullable();
            $table->tinyInteger('is_paid')->default(0)->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
