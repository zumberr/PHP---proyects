@extends('layouts.app')

@section('title', 'Listado de Ventas')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Ventas Registradas</h4>

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
                    <div class="card-body">
                        <a href="{{ route('ventas.create') }}" class="btn btn-primary mb-3">Nueva Venta</a>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <table id="ventasTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Tipo Documento</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ventas as $venta)
                                    <tr>
                                        <td>{{ $venta->id }}</td>
                                        <td>{{ $venta->customer->name }}</td>
                                        <td>{{ $venta->tipodocumento->name }}</td>
                                        <td>{{ $venta->user->name }}</td>
                                        <td>{{ $venta->sale_date }}</td>
                                        <td>$. {{ number_format($venta->total_price, 2) }}</td>
                                        <td>{{ ucfirst($venta->status) }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm view-details" data-id="{{ $venta->id }}">Detalles</button>
                                            <a href="{{ route('ventas.pdf', $venta->id) }}" class="btn btn-danger btn-sm" target="_blank">PDF</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Detalles de Venta -->
<div class="modal fade" id="detalleVentaModal" tabindex="-1" aria-labelledby="detalleVentaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detalleVentaModalLabel">Detalles de la Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="detalleVentaBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#ventasTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            responsive: true,
            autoWidth: false,
            lengthMenu: [10, 25, 50, 75, 100],
            pageLength: 10,
            order: [[0, 'desc']]
        });

        $('.view-details').on('click', function() {
            let ventaId = $(this).data('id');
            $.ajax({
                url: `/ventas/detalle/${ventaId}`,
                method: 'GET',
                success: function(response) {
                    let detalleBody = $('#detalleVentaBody');
                    detalleBody.empty();
                    response.forEach(detalle => {
                        detalleBody.append(`
                            <tr>
                                <td>${detalle.producto.name}</td>
                                <td>${detalle.quantity}</td>
                                <td>$. ${parseFloat(detalle.unit_price).toFixed(2)}</td>
                                <td>$. ${parseFloat(detalle.subtotal).toFixed(2)}</td>
                            </tr>
                        `);
                    });
                    $('#detalleVentaModal').modal('show');
                }
            });
        });
    });
</script>
@endpush
