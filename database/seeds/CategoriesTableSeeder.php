<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_array = ['category1','category2','category3','category4','category5','category6'];
        $parent_array = ['','','','1','4','5,1'];
        $faker = Faker::create();

        $i=0;
        foreach (range(1,6) as $index)
        {
            DB::table('categories')->insert([
                'name' => $category_array[$i],
                'image' => $faker->word.$i.'.jpg',
                'parents' => $parent_array[$i],
            ]);
            $i++;
        }
    }
}
