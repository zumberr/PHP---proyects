@extends('layouts.app')

@section('title', 'Historial de Inventario')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Historial de Inventario</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Inventario</a></li>
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

        <!-- Tabla de Inventarios -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table id="inventoryTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Producto</th>
                                    <th>Cant.</th>
                                    <th>Tipo</th>
                                    <th>Razón</th>
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
                        <p><strong>Cliente/Proveedor:</strong> <span id="detalleEntidad"></span></p>
                        <p><strong>Fecha:</strong> <span id="detalleFecha"></span></p>
                        <p><strong>Usuario:</strong> <span id="detalleUsuario"></span></p>

                        <h5>Productos</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio/Coste</th>
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

@push('styles')
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
@endpush

@push('scripts')
<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        let table = $('#inventoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('inventories.index') }}",
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: [
                { data: 'id' },
                { data: 'producto.name', name: 'producto.name' },
                { data: 'quantity' },
                { data: 'type' },
                { data: 'reason' },
                { data: 'user.name', name: 'user.name' },
                { data: 'created_at' },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `<button class="btn btn-info btn-sm view-detail" data-id="${data}">Ver Detalle</button>`;
                    }
                },
                {
                    data: 'reason',
                    render: function(data, type, row) {
                        let match = data.match(/(Compra|Venta) ID: (\d+)/); // Extraer el tipo y el ID
                        if (match) {
                            let tipo = match[1]; // "Compra" o "Venta"
                            let idReferencia = match[2]; // Número de ID
                            let pdfUrl = tipo === 'Compra' ? `/compras/pdf/${idReferencia}` : `/ventas/pdf/${idReferencia}`;

                            return `<a href="${pdfUrl}" target="_blank" class="btn btn-danger btn-sm">PDF</a>`;
                        }
                        return `<span class="text-muted">No disponible</span>`;
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

        $('#exportExcel').on('click', function(e) {
            e.preventDefault();

            let startDate = $('#start_date').val();
            let endDate = $('#end_date').val();
            let url = "{{ route('inventories.export') }}";

            if (startDate && endDate) {
                url += `?start_date=${startDate}&end_date=${endDate}`;
            }

            window.location.href = url; // Redirige para descargar el archivo
        });

        // Ver detalles en el modal
        $(document).on('click', '.view-detail', function() {
            let id = $(this).data('id');

            $.ajax({
                url: `/inventories/detalle/${id}`,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    $('#detalleId').text(response.id);
                    $('#detalleTipo').text(response.type === 'purchase' ? 'Compra' : 'Venta');
                    $('#detalleEntidad').text(response.supplier?.name || response.customer?.name);
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
