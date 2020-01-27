<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name_array = ['name1','name2','name3','name4','name5','name6','name7','name8','name9','name10'];
        $faker = Faker::create();

        $i=0;
        foreach (range(1,10) as $index)
        {
            DB::table('products')->insert([
                'name' => $name_array[$i],
                'price' => $faker->numberBetween(1000,2000),
                'image' => $faker->word.$i.'.jpg',
                'description' => $faker->paragraph,
            ]);
            $i++;
        }
    }
}
