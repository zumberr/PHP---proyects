<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Compra;
use App\Models\Venta;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Shuchkin\SimpleXLSXGen;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        // Filtrar entre fechas si se proporcionan
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Transaction::with('user');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        if ($request->ajax()) {
            return DataTables::of($query)
                ->editColumn('created_at', function ($transaction) {
                    return Carbon::parse($transaction->created_at)->format('d/m/Y H:i');
                })
                ->addColumn('detalle', function ($transaction) {
                    return '<button class="btn btn-info btn-sm view-detail" data-id="' . $transaction->id . '">Ver Detalle</button>';
                })
                ->addColumn('pdf', function ($transaction) {
                    $pdfUrl = $this->getPdfUrl($transaction);
                    return $pdfUrl ? '<a href="' . $pdfUrl . '" target="_blank" class="btn btn-danger btn-sm">PDF</a>' : '<span class="text-muted">No disponible</span>';
                })
                ->addColumn('user_name', function ($transaction) {
                    return $transaction->user ? $transaction->user->name : '<span class="text-muted">Sin usuario</span>';
                })
                ->rawColumns(['detalle', 'pdf', 'user_name'])
                ->toJson();
        }

        return view('transactions.index');
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
        $transaction = Transaction::findOrFail($id);
        $referenceId = $transaction->reference_id;

        if ($transaction->type === 'purchase') {
            $detalle = Compra::with('detalles.producto', 'supplier', 'user', 'tipodocumento')->find($referenceId);
        } elseif ($transaction->type === 'sale') {
            $detalle = Venta::with('detalles.producto', 'customer', 'user', 'tipodocumento')->find($referenceId);
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
        $query = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select(
                'transactions.id as ID',
                'transactions.type as Tipo',
                'transactions.amount as Monto',
                'transactions.reference_id as Referencia',
                'transactions.description as Descripción',
                'users.name as Usuario',
                'transactions.created_at as Fecha'
            );

        if ($startDate && $endDate) {
            $query->whereBetween('transactions.created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        $transactions = $query->get()->map(function ($transaction) {
            return [
                $transaction->ID,
                ucfirst($transaction->Tipo), // Capitalizar tipo
                number_format($transaction->Monto, 2),
                $transaction->Referencia,
                $transaction->Descripción,
                $transaction->Usuario,
                Carbon::parse($transaction->Fecha)->format('d/m/Y H:i'),
            ];
        });

        $data = array_merge([['ID', 'Tipo', 'Monto', 'Referencia', 'Descripción', 'Usuario', 'Fecha']], $transactions->toArray());

        $xlsx = SimpleXLSXGen::fromArray($data);
        return response()->streamDownload(
            fn() => $xlsx->saveAs('php://output'),
            'transacciones.xlsx'
        );
    }

    private function getPdfUrl($transaction)
    {
        if ($transaction->type === 'purchase') {
            return route('compras.pdf', ['id' => $transaction->reference_id]);
        } elseif ($transaction->type === 'sale') {
            return route('ventas.pdf', ['id' => $transaction->reference_id]);
        }
        return null;
    }
}
