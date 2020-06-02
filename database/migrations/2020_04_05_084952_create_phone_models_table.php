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
            $table->double('width',10,2)->nullable();
            $table->double('height',10,2)->nullable();
            $table->double('position_x',10,2)->nullable();
            $table->double('position_y',10,2)->nullable();
            $table->text('frame')->nullable();
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
