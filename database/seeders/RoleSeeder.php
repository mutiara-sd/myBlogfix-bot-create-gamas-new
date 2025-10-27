<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'Admin', 'slug' => 'admin']);
        Role::create(['name' => 'PM/Owner', 'slug' => 'pm']);
        Role::create(['name' => 'Member', 'slug' => 'member']);
        Role::create(['name' => 'Viewer/Guest', 'slug' => 'guest']);
    }
}
