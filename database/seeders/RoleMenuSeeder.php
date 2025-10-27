<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['menu_id' => 1, 'role_id' => 7],
            ['menu_id' => 2, 'role_id' => 7],
            ['menu_id' => 3, 'role_id' => 1],
            ['menu_id' => 4, 'role_id' => 7],
            ['menu_id' => 5, 'role_id' => 7],
            ['menu_id' => 6, 'role_id' => 4],
            ['menu_id' => 7, 'role_id' => 3],
            ['menu_id' => 7, 'role_id' => 2],
            ['menu_id' => 8, 'role_id' => 7],
            ['menu_id' => 9, 'role_id' => 1],
            ['menu_id' => 10, 'role_id' => 4],
            ['menu_id' => 11, 'role_id' => 4],
            ['menu_id' => 12, 'role_id' => 3],
            ['menu_id' => 12, 'role_id' => 2],
            ['menu_id' => 13, 'role_id' => 3],
            ['menu_id' => 13, 'role_id' => 2],
        ];

        DB::table('role_menus')->insert($data);
    }
}
