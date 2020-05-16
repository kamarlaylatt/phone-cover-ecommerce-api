<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tab_id');
            $table->string('image');
            $table->foreign('tab_id')->references('id')->on('tabs');
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
        Schema::dropIfExists('masks');
    }
}
