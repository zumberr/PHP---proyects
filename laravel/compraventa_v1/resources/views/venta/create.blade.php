@extends('layouts.app')

@section('title', 'Registrar Venta')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Registrar Nueva Venta</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Mantenimiento</a></li>
                            <li class="breadcrumb-item active">Ventas</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="container mt-4">
                        <a href="{{ route('ventas.index') }}" class="btn btn-secondary mb-3">Volver al listado</a>

                        <form action="{{ route('ventas.store') }}" method="POST" id="ventaForm">
                            @csrf
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Cliente</label>
                                <select name="customer_id" class="form-select" id="customer_id" required>
                                    <option value="">Seleccione un cliente</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tipodocumento_id" class="form-label">Tipo de Documento</label>
                                <select name="tipodocumento_id" class="form-select" id="tipodocumento_id" required>
                                    <option value="">Seleccione un tipo de documento</option>
                                    @foreach ($tiposDocumento as $documento)
                                        <option value="{{ $documento->id }}">{{ $documento->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="sale_date" class="form-label">Fecha de Venta</label>
                                <input type="date" name="sale_date" class="form-control" id="sale_date" required>
                            </div>

                            <div class="mb-3">
                                <h5>Detalles de la Venta</h5>
                                <table class="table table-bordered" id="detalleVentaTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 35%">Producto</th>
                                            <th style="width: 10%">Cant</th>
                                            <th style="width: 20%">Precio Unitario</th>
                                            <th style="width: 20%">Subtotal</th>
                                            <th style="width: 15%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-primary" id="addProductRow">Agregar Producto</button>
                            </div>

                            <div class="mb-3">
                                <label for="total_price" class="form-label">Costo Total</label>
                                <input type="text" name="total_price" class="form-control" id="total_price" readonly>
                            </div>

                            <button type="button" class="btn btn-success" id="guardarVenta">Guardar Venta</button>
                            <br/>
                            <br/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const detalleTable = document.querySelector('#detalleVentaTable tbody');
        const addProductRowButton = document.querySelector('#addProductRow');
        const totalPriceInput = document.querySelector('#total_price');
        const guardarVentaButton = document.querySelector('#guardarVenta');
        const ventaForm = document.querySelector('#ventaForm');

        let products = @json($products);

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal-input').forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            totalPriceInput.value = total.toFixed(2);
        }

        function addProductRow() {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>
                    <select class="form-select product-select" required>
                        <option value="">Seleccione un producto</option>
                        ${products.map(product => `<option value="${product.id}">${product.name}</option>`).join('')}
                    </select>
                </td>
                <td><input type="number" class="form-control quantity-input" min="1" required></td>
                <td><input type="number" class="form-control unit-price-input" step="0.01" min="0" required></td>
                <td><input type="text" class="form-control subtotal-input" readonly></td>
                <td><button type="button" class="btn btn-danger remove-row">Eliminar</button></td>
            `;

            detalleTable.appendChild(row);

            $(row.querySelector('.product-select')).select2({
                width: '100%',
                dropdownParent: $('#detalleVentaTable')
            });
        }

        detalleTable.addEventListener('input', function (event) {
            if (event.target.closest('tr')) {
                const row = event.target.closest('tr');
                const quantity = row.querySelector('.quantity-input').value;
                const unitPrice = row.querySelector('.unit-price-input').value;
                const subtotal = row.querySelector('.subtotal-input');
                subtotal.value = (quantity * unitPrice).toFixed(2);
                calculateTotal();
            }
        });

        detalleTable.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-row')) {
                const row = event.target.closest('tr');
                row.remove();
                calculateTotal();
            }
        });

        addProductRowButton.addEventListener('click', function () {
            addProductRow();
        });

        $('#customer_id').select2({
            width: '100%',
        });

        $('#tipodocumento_id').select2({
            width: '100%',
        });

        guardarVentaButton.addEventListener('click', function () {
            const rows = detalleTable.querySelectorAll('tr');
            if (rows.length === 0) {
                Swal.fire('Error', 'Debe agregar al menos un producto al detalle.', 'error');
                return;
            }

            Swal.fire({
                title: '¿Está seguro?',
                text: 'Está a punto de guardar esta venta.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    const detailsInput = document.createElement('input');
                    detailsInput.type = 'hidden';
                    detailsInput.name = 'details';
                    detailsInput.value = JSON.stringify(
                        Array.from(detalleTable.querySelectorAll('tr')).map(row => ({
                            product_id: row.querySelector('.product-select').value,
                            quantity: row.querySelector('.quantity-input').value,
                            unit_price: row.querySelector('.unit-price-input').value,
                        }))
                    );
                    ventaForm.appendChild(detailsInput);

                    ventaForm.submit();
                }
            });
        });
    });
</script>
@endpush
