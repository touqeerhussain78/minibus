<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ComplainCategories extends Migration
{
    public function up()
    {
        Schema::create('complain_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('complain_categories');
    }
}
