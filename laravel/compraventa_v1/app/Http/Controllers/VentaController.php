<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Transaction;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Customer;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class VentaController extends Controller
{

    public function index()
    {
        $ventas = Venta::with(['customer', 'user', 'tipodocumento'])->get();
        return view('venta.index', compact('ventas'));
    }

    public function create()
    {
        $customers = Customer::all();
        $tiposDocumento = TipoDocumento::where('type', 'venta')->get();
        $products = Product::all();
        return view('venta.create', compact('customers', 'tiposDocumento', 'products'));
    }

    public function store(Request $request)
    {
        $details = json_decode($request->details, true);

        if (!is_array($details) || empty($details)) {
            return back()->with('error', 'Los detalles de la venta no son válidos.');
        }

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'tipodocumento_id' => 'required|exists:tipodocumento,id',
            'sale_date' => 'required|date',
            'details' => 'required',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $details) {
            $venta = Venta::create([
                'customer_id' => $request->customer_id,
                'user_id' => auth()->id(),
                'tipodocumento_id' => $request->tipodocumento_id,
                'total_price' => collect($details)->sum(fn($detail) => $detail['quantity'] * $detail['unit_price']),
                'sale_date' => $request->sale_date,
                'status' => 'completed',
            ]);

            foreach ($details as $detail) {
                $product = Product::find($detail['product_id']);

                if ($product->quantity < $detail['quantity']) {
                    throw new \Exception('Stock insuficiente para el producto: ' . $product->name);
                }

                DetalleVenta::create([
                    'sale_id' => $venta->id,
                    'product_id' => $detail['product_id'],
                    'quantity' => $detail['quantity'],
                    'unit_price' => $detail['unit_price'],
                    'subtotal' => $detail['quantity'] * $detail['unit_price'],
                ]);

                Inventory::create([
                    'product_id' => $detail['product_id'],
                    'type' => 'sale',
                    'quantity' => -$detail['quantity'],
                    'reason' => 'Venta ID: ' . $venta->id,
                    'user_id' => auth()->id(),
                ]);

                $product->quantity -= $detail['quantity'];
                $product->save();
            }

            Transaction::create([
                'type' => 'sale',
                'amount' => $venta->total_price,
                'reference_id' => $venta->id,
                'description' => 'Venta ID: ' . $venta->id,
                'user_id' => auth()->id(),
            ]);

            $pdfPath = $this->generateVentaPDF($venta);
            $venta->pdf_path = $pdfPath;
            $venta->save();
        });

        return redirect()->route('ventas.index')->with('success', 'Venta registrada exitosamente.');
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

    private function generateVentaPDF($venta)
    {
        $pdfFileName = 'venta-' . $venta->id . '.pdf';
        $pdfFilePath = 'ventas/' . $pdfFileName;
        $pdfUrl = route('ventas.pdf', ['id' => $venta->id]);

        $qrPath = 'ventas/qr-' . $venta->id . '.svg';
        Storage::disk('public')->put($qrPath, QrCode::format('svg')->size(150)->generate($pdfUrl));

        $qrBase64 = base64_encode(Storage::disk('public')->get($qrPath));

        $pdf = Pdf::loadView('pdf.venta', compact('venta', 'qrBase64'));
        Storage::disk('public')->put($pdfFilePath, $pdf->output());

        return $pdfFilePath;
    }

    public function downloadPDF($id)
    {
        $venta = Venta::findOrFail($id);
        $pdfPath = storage_path('app/public/' . $venta->pdf_path);
        return response()->download($pdfPath);
    }

    public function detalle($id)
    {
        $venta = Venta::with('detalles.producto')->findOrFail($id);
        return response()->json($venta->detalles);
    }
}
