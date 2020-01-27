<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_array = [1,1,2,2,2,3,3,5,5,5];
        $faker = Faker::create();

        $i=0;
        foreach (range(1,10) as $index)
        {
            DB::table('product_categories')->insert([
                'product_id' => $i+1,
                'category_id' => $category_array[$i],
            ]);
            $i++;
        }
    }
}
