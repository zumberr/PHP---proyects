<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        $users = User::whereHas('role',function ($query){
            $query->where('name','Administrador')->orWhere('name','Mantenedor');
        })->get();

        $products = [
            ['name' => 'Laptop HP', 'description' => 'Laptop HP con 8GB de RAM y 256GB SSD', 'price' => 750.00, 'quantity' => 10],
            ['name' => 'Teclado Mecánico', 'description' => 'Teclado RGB mecánico de alta calidad', 'price' => 50.00, 'quantity' => 20],
            ['name' => 'Monitor Samsung', 'description' => 'Monitor curvo Samsung de 27 pulgadas', 'price' => 200.00, 'quantity' => 15],
            ['name' => 'Procesador Intel i7', 'description' => 'Procesador Intel Core i7 11va Gen', 'price' => 300.00, 'quantity' => 25],
            ['name' => 'Router TP-Link', 'description' => 'Router inalámbrico de doble banda', 'price' => 80.00, 'quantity' => 18],
            ['name' => 'Audífonos Gaming', 'description' => 'Audífonos con micrófono para gamers', 'price' => 35.00, 'quantity' => 30],
            ['name' => 'Mouse Gamer', 'description' => 'Mouse gamer con 7 botones programables', 'price' => 25.00, 'quantity' => 40],
            ['name' => 'Memoria RAM 16GB', 'description' => 'Memoria RAM DDR4 de 16GB 3200MHz', 'price' => 90.00, 'quantity' => 50],
            ['name' => 'Disco Duro 1TB', 'description' => 'Disco duro interno de 1TB para PCs', 'price' => 60.00, 'quantity' => 35],
            ['name' => 'Cámara Web', 'description' => 'Cámara web HD con micrófono integrado', 'price' => 40.00, 'quantity' => 22],
            ['name' => 'Laptop Dell', 'description' => 'Laptop Dell con 16GB RAM y 512GB SSD', 'price' => 900.00, 'quantity' => 12],
            ['name' => 'Switch Gigabit', 'description' => 'Switch de red con 8 puertos Gigabit', 'price' => 70.00, 'quantity' => 15],
            ['name' => 'Tarjeta Gráfica RTX 3060', 'description' => 'Tarjeta gráfica NVIDIA RTX 3060', 'price' => 450.00, 'quantity' => 10],
            ['name' => 'Fuente de Poder 650W', 'description' => 'Fuente de poder 80+ Bronze de 650W', 'price' => 60.00, 'quantity' => 25],
            ['name' => 'Placa Madre MSI', 'description' => 'Placa madre MSI compatible con Intel', 'price' => 120.00, 'quantity' => 20],
            ['name' => 'SSD 512GB', 'description' => 'Disco sólido SSD de 512GB', 'price' => 70.00, 'quantity' => 30],
            ['name' => 'Case Gaming', 'description' => 'Case ATX con ventiladores RGB', 'price' => 80.00, 'quantity' => 12],
            ['name' => 'Kit de Herramientas', 'description' => 'Kit de herramientas para armado de PC', 'price' => 25.00, 'quantity' => 40],
            ['name' => 'Monitor LG', 'description' => 'Monitor ultrawide LG de 29 pulgadas', 'price' => 300.00, 'quantity' => 8],
            ['name' => 'Cable HDMI', 'description' => 'Cable HDMI 2.1 de alta velocidad', 'price' => 15.00, 'quantity' => 100],
        ];

        foreach($products as $product){
            Product::create([
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
                'category_id' => $categories->random()->id,
                'user_id' => $users->random()->id,
                'status' => 'available',
            ]);
        }
    }
}
