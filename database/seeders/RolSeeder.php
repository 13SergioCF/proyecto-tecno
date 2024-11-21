<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        $adminRole = Role::create(['name' => 'Admin']);
        $pacienteRole = Role::create(['name' => 'Paciente']);

        // Crear permisos
        $permissionManageUsers = Permission::create(['name' => 'manage-users']);
        $permissionManageRoles = Permission::create(['name' => 'manage-roles']);
        $permissionManagePermissions = Permission::create(['name' => 'manage-permissions']);
        $permissionViewHome = Permission::create(['name' => 'view-home']);
        $permissionManageDiet = Permission::create(['name' => 'manage-diet']);
        $permissionManageExercise = Permission::create(['name' => 'manage-exercise']);
        $permissionManagePeriod = Permission::create(['name' => 'manage-period']);
        
        // Asignar permisos a los roles
        $adminRole->givePermissionTo([
            $permissionManageUsers,
            $permissionManageRoles,
            $permissionManagePermissions,
            $permissionViewHome,
            $permissionManageDiet,
            $permissionManageExercise,
            $permissionManagePeriod
        ]);

        // El rol "Paciente" solo tiene permisos limitados
        $pacienteRole->givePermissionTo([
            $permissionManageUsers, 
            $permissionViewHome
        ]);

        // Crear un usuario con rol Admin
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678')
        ]);
        $adminUser->assignRole('Admin');

        // Crear un usuario con rol Paciente
        $pacienteUser = User::create([
            'name' => 'Paciente',
            'email' => 'paciente@paciente.com',
            'password' => bcrypt('12345678')
        ]);
        $pacienteUser->assignRole('Paciente');
    }
}
