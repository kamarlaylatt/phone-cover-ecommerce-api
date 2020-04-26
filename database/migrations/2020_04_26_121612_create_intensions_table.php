<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intensions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->integer('type');
            $table->unsignedBigInteger('phone_model_id');
            $table->unsignedBigInteger('shell_material_id');
            $table->string('preview')->nullable();
            $table->decimal('price',8,2)->default(0);
            $table->integer('print_status')->default(1);
            $table->string('remark')->nullable();
            $table->foreign('phone_model_id')->references('id')->on('phone_models');
            $table->foreign('shell_material_id')->references('id')->on('shell_materials');
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
        Schema::dropIfExists('intensions');
    }
}
