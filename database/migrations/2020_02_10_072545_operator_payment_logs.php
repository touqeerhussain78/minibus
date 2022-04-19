<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OperatorPaymentLogs extends Migration
{
    public function up()
    {
        Schema::create('operator_payment_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('operator_id')->nullable();
            $table->integer('quotation_package_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('stripe_charge_id')->nullable();
            $table->json('details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('operator_payment_logs');
    }
}
