<?php

use Illuminate\Database\Seeder;
use App\OrderStatus;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::Create([
            'name' => 'order',
            'sort_index' => 1,
            'icon' => 'icon.jpg',
            'description' => 'order status'
        ]);

    }
}
