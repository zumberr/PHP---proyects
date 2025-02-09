<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Transaction;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class CompraController extends Controller
{

    public function index()
    {
        $compras = Compra::with(['supplier', 'user', 'tipodocumento'])->get();
        return view('compra.index', compact('compras'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $tiposDocumento = TipoDocumento::where('type', 'compra')->get();
        $products = Product::all();
        return view('compra.create', compact('suppliers', 'tiposDocumento', 'products'));
    }

    public function store(Request $request)
    {
        // Decodificar el JSON en un array PHP
        $details = json_decode($request->details, true);

        // Validar que `details` se haya convertido correctamente en un array
        if (!is_array($details) || empty($details)) {
            return back()->with('error', 'Los detalles de la compra no son válidos.');
        }

        // Validar los datos
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'tipodocumento_id' => 'required|exists:tipodocumento,id',
            'purchase_date' => 'required|date',
            'details' => 'required',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.unit_cost' => 'required|numeric|min:0',
        ]);

        // Iniciar transacción
        DB::transaction(function () use ($request, $details) {
            // Crear la compra
            $compra = Compra::create([
                'supplier_id' => $request->supplier_id,
                'user_id' => auth()->id(),
                'tipodocumento_id' => $request->tipodocumento_id,
                'total_cost' => collect($details)->sum(fn($detail) => $detail['quantity'] * $detail['unit_cost']),
                'purchase_date' => $request->purchase_date,
                'status' => 'completed',
            ]);

            // Registrar detalles de la compra
            foreach ($details as $detail) {
                DetalleCompra::create([
                    'purchase_id' => $compra->id,
                    'product_id' => $detail['product_id'],
                    'quantity' => $detail['quantity'],
                    'unit_cost' => $detail['unit_cost'],
                    'subtotal' => $detail['quantity'] * $detail['unit_cost'],
                ]);

                // Actualizar inventario
                Inventory::create([
                    'product_id' => $detail['product_id'],
                    'type' => 'purchase',
                    'quantity' => $detail['quantity'],
                    'reason' => 'Compra ID: ' . $compra->id,
                    'user_id' => auth()->id(),
                ]);

                // Actualizar stock del producto
                $product = Product::find($detail['product_id']);
                $product->quantity += $detail['quantity'];
                $product->save();
            }

            // Registrar la transacción
            Transaction::create([
                'type' => 'purchase',
                'amount' => $compra->total_cost,
                'reference_id' => $compra->id,
                'description' => 'Compra ID: ' . $compra->id,
                'user_id' => auth()->id(),
            ]);

            // **Generar PDF**
            $pdfPath = $this->generateCompraPDF($compra);

            // Guardar el nombre del archivo en la base de datos si lo necesitas
            $compra->pdf_path = $pdfPath;
            $compra->save();
        });

        return redirect()->route('compras.index')->with('success', 'Compra registrada exitosamente.');
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

    private function generateCompraPDF($compra)
    {
        $pdfFileName = 'compra-' . $compra->id . '.pdf';
        $pdfFilePath = 'compras/' . $pdfFileName;

        $pdfUrl = route('compras.pdf', ['id' => $compra->id]); // Ruta del PDF para el QR

        // **Generar y guardar el QR en formato SVG**
        $qrPath = 'compras/qr-' . $compra->id . '.svg';
        Storage::disk('public')->put($qrPath, QrCode::format('svg')->size(150)->generate($pdfUrl));

        // **Convertir el SVG a Base64 para incrustarlo en el PDF**
        $qrBase64 = base64_encode(Storage::disk('public')->get($qrPath));

        $pdf = Pdf::loadView('pdf.compra', compact('compra', 'qrBase64'));

        // Guardar el PDF en storage
        Storage::disk('public')->put($pdfFilePath, $pdf->output());

        return $pdfFilePath;
    }

    public function downloadPDF($id)
    {
        $compra = Compra::findOrFail($id);
        $pdfPath = storage_path('app/public/' . $compra->pdf_path);

        return response()->download($pdfPath);
    }

    public function detalle($id)
    {
        $compra = Compra::with('detalles.producto')->findOrFail($id);
        return response()->json($compra->detalles);
    }
}
