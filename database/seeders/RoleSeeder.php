<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name'=>'admin']);
        $usuario = Role::create(['name' => 'usuario']);

        Permission::create(['name' => 'ver-rol'])->assignRole($admin);
        Permission::create(['name' => 'crear-rol'])->assignRole($admin);
        Permission::create(['name' => 'editar-rol'])->assignRole($admin);
        Permission::create(['name' => 'borrar-rol'])->assignRole($admin);

        Permission::create(['name' => 'ver-usuarios'])->assignRole($admin);
        Permission::create(['name' => 'crear-usuarios'])->assignRole($admin);
        Permission::create(['name' => 'editar-usuarios'])->assignRole($admin);
        Permission::create(['name' => 'borrar-usuarios'])->assignRole($admin);
        
    }
}
