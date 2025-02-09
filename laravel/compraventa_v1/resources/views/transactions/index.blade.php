@extends('layouts.app')

@section('title', 'Historial de Transacciones')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Historial de Transacciones</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Transacciones</a></li>
                            <li class="breadcrumb-item active">Historial</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="start_date">Fecha inicio:</label>
                <input type="date" id="start_date" class="form-control">
            </div>

            <div class="col-md-3">
                <label for="end_date">Fecha fin:</label>
                <input type="date" id="end_date" class="form-control">
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button id="filterBtn" class="btn btn-primary w-100">Filtrar</button>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <a id="exportExcel" href="#" class="btn btn-success w-100">Exportar a Excel</a>
            </div>
        </div>

        <!-- Tabla de Transacciones -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table id="transactionsTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tipo</th>
                                    <th>Monto</th>
                                    <th>Referencia</th>
                                    <th>Descripción</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                        <br/>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Detalle -->
        <div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detalleModalLabel">Detalles</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>Información General</h5>
                        <p><strong>ID:</strong> <span id="detalleId"></span></p>
                        <p><strong>Tipo:</strong> <span id="detalleTipo"></span></p>
                        <p><strong>Referencia:</strong> <span id="detalleReferencia"></span></p>
                        <p><strong>Fecha:</strong> <span id="detalleFecha"></span></p>
                        <p><strong>Usuario:</strong> <span id="detalleUsuario"></span></p>

                        <h5>Productos</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="detalleProductos"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let table = $('#transactionsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('transactions.index') }}",
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: [
                { data: 'id' },
                { data: 'type' },
                { data: 'amount' },
                { data: 'reference_id' },
                { data: 'description' },
                { data: 'user.name', name: 'user.name' },
                {
                    data: 'created_at',
                    render: function(data) {
                        return data ? data : '<span class="text-muted">Sin fecha</span>';
                    }
                },
                {
                    data: 'id',
                    render: function(data) {
                        return `<button class="btn btn-info btn-sm view-detail" data-id="${data}">Ver Detalle</button>`;
                    }
                },
                {
                    data: 'reference_id',
                    render: function(data, type, row) {
                        let pdfUrl = row.type === 'purchase' ? `/compras/pdf/${data}` : `/ventas/pdf/${data}`;
                        return `<a href="${pdfUrl}" target="_blank" class="btn btn-danger btn-sm">PDF</a>`;
                    }
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            responsive: true,
            autoWidth: false,
            lengthMenu: [10, 25, 50, 75, 100],
            pageLength: 10,
            order: [[0, 'desc']]
        });

        // Aplicar filtro al hacer clic en el botón
        $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });

        // Exportar a Excel según las fechas seleccionadas
        $('#exportExcel').on('click', function(e) {
            e.preventDefault();

            let startDate = $('#start_date').val();
            let endDate = $('#end_date').val();
            let url = "{{ route('transactions.export') }}";

            if (startDate && endDate) {
                url += `?start_date=${startDate}&end_date=${endDate}`;
            }

            window.location.href = url;
        });

        // Ver detalles en el modal
        $(document).on('click', '.view-detail', function() {
            let id = $(this).data('id');

            $.ajax({
                url: `/transactions/detalle/${id}`,
                method: 'GET',
                success: function(response) {
                    $('#detalleId').text(response.id);
                    $('#detalleTipo').text(response.type === 'purchase' ? 'Compra' : 'Venta');
                    $('#detalleReferencia').text(response.reference_id);
                    $('#detalleFecha').text(new Date(response.created_at).toLocaleDateString('es-ES'));
                    $('#detalleUsuario').text(response.user.name);

                    let productosHtml = '';
                    response.detalles.forEach(detalle => {
                        productosHtml += `
                            <tr>
                                <td>${detalle.producto.name}</td>
                                <td>${detalle.quantity}</td>
                                <td>${detalle.unit_price ?? detalle.unit_cost}</td>
                                <td>${detalle.subtotal}</td>
                            </tr>
                        `;
                    });
                    $('#detalleProductos').html(productosHtml);

                    $('#detalleModal').modal('show');
                },
                error: function() {
                    alert('No se encontraron detalles.');
                }
            });
        });

    });
</script>
@endpush
