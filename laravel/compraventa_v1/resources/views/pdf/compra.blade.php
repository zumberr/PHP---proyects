<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra #{{ $compra->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Compra #{{ $compra->id }}</h2>
    <p><strong>Proveedor:</strong> {{ $compra->supplier->name }}</p>
    <p><strong>Fecha:</strong> {{ $compra->purchase_date }}</p>
    <p><strong>Total:</strong> $. {{ number_format($compra->total_cost, 2) }}</p>

    <h3>Detalles de la compra</h3>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Costo Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($compra->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->name }}</td>
                    <td>{{ $detalle->quantity }}</td>
                    <td>$. {{ number_format($detalle->unit_cost, 2) }}</td>
                    <td>$. {{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>QR Code</h3>
    @if($qrBase64)
        <img src="data:image/svg+xml;base64,{{ $qrBase64 }}" style="width: 150px; height: 150px;">
    @else
        <p>Error al cargar el QR</p>
    @endif

</body>
</html>
