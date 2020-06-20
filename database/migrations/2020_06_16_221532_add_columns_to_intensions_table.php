<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToIntensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('intensions', function (Blueprint $table) {
            $table->dropColumn('print_status');
            $table->string('order_no')->after('address')->unique();
            $table->unsignedBigInteger('user_id')->after('id');
            $table->unsignedBigInteger('order_status_id')->after('price');
            $table->foreign('order_status_id')->references('id')->on('order_statuses');
            $table->foreign('user_id')->references('id')->on('users');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('intensions', function (Blueprint $table) {
            //
        });
    }
}
