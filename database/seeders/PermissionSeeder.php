<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::create(['name' => 'manage-users']);
        Permission::create(['name' => 'manage-roles']);
        Permission::create(['name' => 'manage-permissions']);
        Permission::create(['name' => 'view-home']);
    }
}
