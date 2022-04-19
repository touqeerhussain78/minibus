<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OperatorRatings extends Migration
{
    public function up()
    {
        Schema::create('operator_ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('booking_id');
            $table->integer('operator_id');
            $table->string('comments')->nullable();
            $table->string('rating')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('operator_ratings');
    }
}
