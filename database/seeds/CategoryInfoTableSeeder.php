<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CategoryInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_array = ['category1','category2','category3','category4','category5','category6','အမျိုးအစား၁','အမျိုးအစား၂','အမျိုးအစား၃','အမျိုးအစား၄','အမျိုးအစား၅','အမျိုးအစား၆'];
        $category_id = [1,2,3,4,5,6,1,2,3,4,5,6];
        $language_id = [1,1,1,1,1,1,2,2,2,2,2,2];
        $faker = Faker::create();

        $i=0;
        foreach (range(1,12) as $index)
        {
            DB::table('category_infos')->insert([
                'name' => $category_array[$i],
                'description' => $faker->paragraph,
                'category_id' => $category_id[$i],
                'language_id' => $language_id[$i],
            ]);
            $i++;
        }
    }
}
