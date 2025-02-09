<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoDocumento;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoDocumento =[
            ['name' => 'Factura', 'description' => 'Documento utilizado para ventas', 'type' => 'venta'],
            ['name' => 'Boleta', 'description' => 'Documento utilizado para ventas', 'type' => 'venta'],
            ['name' => 'Guia de Remision', 'description' => 'Documento utilizado para compras', 'type' => 'compra'],
        ];

        foreach ($tipoDocumento as $tipo){
            TipoDocumento::create($tipo);
        }
    }
}
