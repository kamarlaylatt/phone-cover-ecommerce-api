<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('phone_brand_id');
            $table->foreign('phone_brand_id')->references('id')->on('phone_brands');
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
        Schema::dropIfExists('phone_models');
    }
}
