<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('remain_amount',8,2)->default(0)->after('total_amount');
            $table->decimal('pay_amount',8,2)->default(0)->after('total_amount');
            $table->decimal('total_net',8,2)->default(0)->after('total_amount');
            $table->decimal('delivery_cost',8,2)->default(0)->after('total_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
