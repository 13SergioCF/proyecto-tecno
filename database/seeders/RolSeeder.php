<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles1= Role:: create(['name'=> 'Admin']);
        $roles2= Role:: create(['name'=> 'Paciente']);

        //creando permisos

        //Permission:: create(['name'=> 'home'])->assignRole($role);/// solo sirve para un rol un permiso 
        Permission:: create(['name'=> 'home'])->syncRoles($roles1, $roles2);// sirve para un rol varios permisos
    }
}
