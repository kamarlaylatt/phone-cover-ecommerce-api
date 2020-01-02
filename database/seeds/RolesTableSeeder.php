<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_roles')->insert([
            'name' => 'Super Admin',
            'description' => 'Super Admin can control the whole system.',
        ]);

        DB::table('admin_roles')->insert([
            'name' => 'Editor',
            'description' => 'Editor can edit the system with their permission.',
        ]);
    }
}
