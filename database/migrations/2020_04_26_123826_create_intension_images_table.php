<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntensionImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intension_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('intension_id');
            $table->string('image');
            $table->foreign('intension_id')->references('id')->on('intensions')->onDelete('cascade');
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
        Schema::dropIfExists('intension_images');
    }
}
