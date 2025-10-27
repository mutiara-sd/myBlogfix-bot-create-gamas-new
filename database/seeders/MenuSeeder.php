<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dashboard = Menu::create([
            'name' => 'Dashboard',
            'route' => '/dashboard',
            'icon' => 'Dashboard',
            'list' => '1',
        ]);

        $apps = Menu::create([
            'name' => 'Apps',
            'route' => '#',
            'icon' => 'grid',
            'list' => '2',
        ]);

        $auth = Menu::create([
            'name' => 'Authentication',
            'route' => '#',
            'icon' => 'users',
            'list' => '3',
        ]);

        // Submenu of Apps
        $calendar = Menu::create([
            'menu_id' => $apps->id,
            'name' => 'Calendar',
            'route' => '/calendar',
        ]);

        Menu::create([
            'menu_id' => $apps->id,
            'name' => 'Chat',
            'route' => '/chat',
        ]);

        $email = Menu::create([
            'menu_id' => $apps->id,
            'name' => 'Email',
            'route' => '#',
        ]);

        $invoices = Menu::create([
            'menu_id' => $apps->id,
            'name' => 'Invoices',
            'route' => '#',
        ]);

        Menu::create([
            'menu_id' => $apps->id,
            'name' => 'Contact',
            'route' => '/contact',
        ]);

        Menu::create([
            'menu_id' => $auth->id,
            'name' => 'Verify Users',
            'route' => '/admin',
        ]);

        // Submenu of Email
        Menu::create([
            'menu_id' => $email->id,
            'name' => 'Inbox',
            'route' => '/inbox-mail',
        ]);

        Menu::create([
            'menu_id' => $email->id,
            'name' => 'Read Email',
            'route' => '/read-email',
        ]);

        // Submenu of Invoices
        Menu::create([
            'menu_id' => $invoices->id,
            'name' => 'Invoices List',
            'route' => '/invoices-list',
        ]);

        Menu::create([
            'menu_id' => $invoices->id,
            'name' => 'Invoices Detail',
            'route' => '/invoices-detail',
        ]);
    }
}
