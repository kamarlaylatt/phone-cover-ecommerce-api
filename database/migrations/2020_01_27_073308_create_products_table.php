<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('code_number');
            $table->decimal('price', 8, 2)->default(0);
            $table->integer('qty')->default(0);
            $table->integer('min_order')->default(0);
            $table->integer('max_order')->default(0);
            $table->integer('recomand')->default(0);
            $table->text('image')->nullable(); 
            $table->string('seo_key')->nullable();
            $table->string('fb_pixel')->nullable();
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
        Schema::dropIfExists('products');
    }
}
