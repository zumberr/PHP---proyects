<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Venta;
use App\Models\Compra;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

use App\Models\DetalleVenta;
use App\Models\DetalleCompra;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function getChartData()
    {
        // Ventas y compras por mes en los últimos 6 meses
        $ventas = Venta::select(DB::raw("SUM(total_price) as total"), DB::raw("DATE_FORMAT(sale_date, '%Y-%m') as month"))
            ->where('sale_date', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $compras = Compra::select(DB::raw("SUM(total_cost) as total"), DB::raw("DATE_FORMAT(purchase_date, '%Y-%m') as month"))
            ->where('purchase_date', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Transacciones de ventas y compras
        $totalVentas = Venta::sum('total_price');
        $totalCompras = Compra::sum('total_cost');

        return response()->json([
            'ventas' => $ventas,
            'compras' => $compras,
            'totalVentas' => $totalVentas,
            'totalCompras' => $totalCompras,
        ]);
    }

    public function getDashboardStats()
    {
        return response()->json([
            'totalCategorias' => Category::count(),
            'totalProductos' => Product::count(),
            'totalCompras' => Compra::count(),
            'totalVentas' => Venta::count(),
            'totalUsuarios' => User::count(),
        ]);
    }

    public function getProductDistribution()
    {
        // Obtener los productos más vendidos
        $ventas = DetalleVenta::select(
                'products.name as producto',
                DB::raw('SUM(detalle_ventas.quantity) as total_vendido')
            )
            ->join('products', 'detalle_ventas.product_id', '=', 'products.id')
            ->groupBy('products.name')
            ->orderByDesc('total_vendido')
            ->limit(5) // Limitar a los 5 productos más vendidos
            ->get();

        // Obtener los productos más comprados
        $compras = DetalleCompra::select(
                'products.name as producto',
                DB::raw('SUM(detalle_compras.quantity) as total_comprado')
            )
            ->join('products', 'detalle_compras.product_id', '=', 'products.id')
            ->groupBy('products.name')
            ->orderByDesc('total_comprado')
            ->limit(5) // Limitar a los 5 productos más comprados
            ->get();

        return response()->json([
            'ventas' => $ventas,
            'compras' => $compras
        ]);
    }

    public function getTopCustomersSuppliers()
    {
        // Obtener los 5 clientes con mayor monto de compras
        $topClientes = Venta::select(
                'customers.name as cliente',
                DB::raw('SUM(ventas.total_price) as total_ventas')
            )
            ->join('customers', 'ventas.customer_id', '=', 'customers.id')
            ->groupBy('customers.name')
            ->orderByDesc('total_ventas')
            ->limit(5)
            ->get();

        // Obtener los 5 proveedores con mayor monto de ventas
        $topProveedores = Compra::select(
                'suppliers.name as proveedor',
                DB::raw('SUM(compras.total_cost) as total_compras')
            )
            ->join('suppliers', 'compras.supplier_id', '=', 'suppliers.id')
            ->groupBy('suppliers.name')
            ->orderByDesc('total_compras')
            ->limit(5)
            ->get();

        return response()->json([
            'topClientes' => $topClientes,
            'topProveedores' => $topProveedores
        ]);
    }
}
