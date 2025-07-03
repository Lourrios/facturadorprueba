<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',
            
            'ver-usuarios',
            'crear-usuarios',
            'editar-usuarios',
            'borrar-usuarios',


            'ver-clientes',
            'crear-clientes',
            'editar-clientes',
            'borrar-clientes',

            'ver-facturas',
            'crear-facturas',
            'editar-facturas',
            'borrar-facturas',

            'ver-pago',
            'crear-pago',
            'editar-pago',
            'borrar-pago',
        ];
        
        foreach($permisos as $permiso){
          Permission::firstOrCreate(['name' => $permiso, 'guard_name' => 'web']);
        }
        
    }
}
