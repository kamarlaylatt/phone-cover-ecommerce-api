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
            'name' => 'peinding',
            'sort_index' => 1,
            'icon' => 'icon.jpg',
            'description' => 'order status'
        ]);

        OrderStatus::Create([
            'name' => 'complete',
            'sort_index' => 2,
            'icon' => 'icon.jpg',
            'description' => 'order status'
        ]);

    }
}
