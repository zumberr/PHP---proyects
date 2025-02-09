<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Transaction;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Customer;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\DB;

class VentaSeeder extends Seeder
{

    public function run()
    {
        DB::transaction(function () {
            // Obtener clientes y tipos de documento
            $customers = Customer::all();
            $tiposDocumento = TipoDocumento::where('type', 'venta')->get();
            $products = Product::where('quantity', '>', 0)->get(); // Solo productos con stock disponible

            if ($customers->isEmpty() || $tiposDocumento->isEmpty() || $products->isEmpty()) {
                $this->command->warn('No hay datos suficientes en customers, tipos_documento o products con stock para generar ventas.');
                return;
            }

            // Generar 10 ventas de prueba
            for ($i = 0; $i < 100; $i++) {
                $customer = $customers->random();
                $tipoDocumento = $tiposDocumento->random();

                // Crear la venta
                $venta = Venta::create([
                    'customer_id' => $customer->id,
                    'user_id' => 1, // Ajustar según el usuario administrador o de prueba
                    'tipodocumento_id' => $tipoDocumento->id,
                    'total_price' => 0, // Se actualizará después de agregar detalles
                    'sale_date' => now()->subDays(rand(1, 30)), // Fecha aleatoria en el último mes
                    'status' => 'completed',
                ]);

                $totalPrice = 0;

                // Cada venta tendrá entre 1 y 5 productos vendidos
                $detalleCount = rand(1, 5);
                for ($j = 0; $j < $detalleCount; $j++) {
                    $product = $products->random();
                    if ($product->quantity < 1) continue; // Evitar vender productos sin stock

                    $quantity = rand(1, min(5, $product->quantity)); // No vender más de lo que hay en stock
                    $unitPrice = rand(10, 100);
                    $subtotal = $quantity * $unitPrice;

                    // Crear detalle de venta
                    DetalleVenta::create([
                        'sale_id' => $venta->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'subtotal' => $subtotal,
                    ]);

                    // Registrar en inventario (descontando stock)
                    Inventory::create([
                        'product_id' => $product->id,
                        'type' => 'sale',
                        'quantity' => -$quantity, // Se resta del stock
                        'reason' => 'Venta ID: ' . $venta->id,
                        'user_id' => 1, // Ajustar según el usuario administrador o de prueba
                    ]);

                    // Actualizar stock del producto
                    $product->quantity -= $quantity;
                    $product->save();

                    // Sumar al total de la venta
                    $totalPrice += $subtotal;
                }

                // Actualizar el total de la venta
                $venta->update(['total_price' => $totalPrice]);

                // Registrar la transacción
                Transaction::create([
                    'type' => 'sale',
                    'amount' => $totalPrice,
                    'reference_id' => $venta->id,
                    'description' => 'Venta ID: ' . $venta->id,
                    'user_id' => 1, // Ajustar según el usuario administrador o de prueba
                ]);
            }

            $this->command->info('Se generaron ventas de prueba con detalles.');
        });
    }
}
