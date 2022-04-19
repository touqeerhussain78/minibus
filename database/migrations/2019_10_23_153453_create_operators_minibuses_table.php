<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperatorsMinibusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operators_minibuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('operator_id');
            $table->string('model')->nullable();
            $table->string('capacity')->nullable();
            $table->tinyInteger('type');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('operators_minibuses');
    }
}
