<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Inventory;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventoryExport;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\DB;

use Shuchkin\SimpleXLSXGen;

class InventoryController extends Controller
{

    public function index(Request $request)
    {
        // Filtrar entre fechas si se proporcionan
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Inventory::with('producto', 'user');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        if ($request->ajax()) {
            return DataTables::of($query)
            ->editColumn('created_at', function ($inventory) {
                return \Carbon\Carbon::parse($inventory->created_at)->format('d/m/Y H:i');
            })
            ->toJson();
        }

        return view('inventories.index');
    }


    public function create()
    {

    }


    public function store(Request $request)
    {

    }


    public function show(string $id)
    {

    }

    public function edit(string $id)
    {

    }


    public function update(Request $request, string $id)
    {

    }


    public function destroy(string $id)
    {

    }

    public function detalle($id)
    {
        $inventory = Inventory::findOrFail($id);

        // Extraer el ID de referencia desde `reason`
        preg_match('/(Compra|Venta) ID: (\d+)/', $inventory->reason, $matches);

        if (!$matches) {
            return response()->json(['error' => 'No se encontró un ID válido en el campo reason'], 404);
        }

        $tipo = $matches[1]; // "Compra" o "Venta"
        $referenciaId = $matches[2]; // Número de ID

        if ($tipo === 'Compra') {
            $detalle = \App\Models\Compra::with('detalles.producto', 'supplier', 'user', 'tipodocumento')
                ->where('id', $referenciaId)
                ->first();
        } elseif ($tipo === 'Venta') {
            $detalle = \App\Models\Venta::with('detalles.producto', 'customer', 'user', 'tipodocumento')
                ->where('id', $referenciaId)
                ->first();
        } else {
            return response()->json(['error' => 'No se encontraron detalles'], 404);
        }

        return response()->json($detalle);
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Obtener datos filtrados o todos si no hay filtros
        $query = DB::table('inventories')
            ->join('products', 'inventories.product_id', '=', 'products.id')
            ->join('users', 'inventories.user_id', '=', 'users.id')
            ->select(
                'inventories.id as ID',
                'products.name as Producto',
                'inventories.quantity as Cantidad',
                'inventories.type as Tipo',
                'inventories.reason as Razón',
                'users.name as Usuario',
                'inventories.created_at as Fecha'
            );

        if ($startDate && $endDate) {
            $query->whereBetween('inventories.created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        $inventories = $query->get()->map(function ($inventory) {
            return [
                $inventory->ID,
                $inventory->Producto,
                $inventory->Cantidad,
                $inventory->Tipo,
                $inventory->Razón,
                $inventory->Usuario,
                Carbon::parse($inventory->Fecha)->format('d/m/Y H:i'),
            ];
        });

        $data = array_merge([['ID', 'Producto', 'Cantidad', 'Tipo', 'Razón', 'Usuario', 'Fecha']], $inventories->toArray());

        $xlsx = SimpleXLSXGen::fromArray($data);
        return response()->streamDownload(
            fn() => $xlsx->saveAs('php://output'),
            'inventario.xlsx'
        );
    }
}
