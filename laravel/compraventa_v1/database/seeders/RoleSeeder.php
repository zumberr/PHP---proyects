<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrador', 'description' => 'Gestiona todo el sistema.'],
            ['name' => 'Vendedor', 'description' => 'Se encarga de las ventas.'],
            ['name' => 'Comprador', 'description' => 'Se encarga de las compras.'],
            ['name' => 'Mantenedor', 'description' => 'Responsable del mantenimiento de datos.'],
            ['name' => 'Analista', 'description' => 'Analiza datos.'],
            ['name' => 'Almacen', 'description' => 'Gestiona Inventario.'],
        ];

        foreach ($roles as $role){
            Role::create($role);
        }

    }
}
