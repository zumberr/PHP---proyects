@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card crm-widget">
                        <div class="card-body p-0">
                            <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">

                                <div class="col">
                                    <div class="py-4 px-3">
                                        <h5 class="text-muted text-uppercase fs-13">Total Categorías</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="ri-database-2-line display-6 text-muted"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h2 class="mb-0"><span class="counter-value" id="totalCategorias">0</span></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="py-4 px-3">
                                        <h5 class="text-muted text-uppercase fs-13">Total Productos</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="ri-shopping-cart-line display-6 text-muted"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h2 class="mb-0"><span class="counter-value" id="totalProductos">0</span></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="py-4 px-3">
                                        <h5 class="text-muted text-uppercase fs-13">Total Compras</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="ri-wallet-line display-6 text-muted"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h2 class="mb-0"><span class="counter-value" id="totalCompras">0</span></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="py-4 px-3">
                                        <h5 class="text-muted text-uppercase fs-13">Total Ventas</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="ri-money-dollar-circle-line display-6 text-muted"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h2 class="mb-0"><span class="counter-value" id="totalVentas">0</span></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="py-4 px-3">
                                        <h5 class="text-muted text-uppercase fs-13">Total Usuarios</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="ri-user-line display-6 text-muted"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h2 class="mb-0"><span class="counter-value" id="totalUsuarios">0</span></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- end row -->
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Ventas</h5>
                            <h2 id="totalVentas1">0</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Compras</h5>
                            <h2 id="totalCompras1">0</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Comparación de Ventas y Compras (Últimos 6 meses)</h4>
                            <div id="ventasComprasChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <!-- Gráfico de Ventas por Producto -->
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Distribución de Ventas por Producto</h4>
                            <div id="ventasProductosChart"></div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Compras por Producto -->
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Distribución de Compras por Producto</h4>
                            <div id="comprasProductosChart"></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <!-- Gráfico de Top Clientes -->
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Top 5 Clientes con Mayor Monto de Ventas ($)</h4>
                            <div id="topClientesChart"></div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Top Proveedores -->
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Top 5 Proveedores con Mayor Monto de Compras ($)</h4>
                            <div id="topProveedoresChart"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<!-- <script src="{{ asset('assets/js/pages/dashboard-crm.init.js') }}"></script> -->

<script>
    document.addEventListener('DOMContentLoaded', function () {

        fetch("{{ route('dashboard.data') }}")
            .then(response => response.json())
            .then(data => {
                // Actualizar Totales
                document.getElementById('totalVentas1').innerText = `$ ${data.totalVentas}`;
                document.getElementById('totalCompras1').innerText = `$ ${data.totalCompras}`;

                // Preparar datos para el gráfico
                let meses = [...new Set([...data.ventas.map(v => v.month), ...data.compras.map(c => c.month)])].sort();
                let ventasData = meses.map(m => {
                    let venta = data.ventas.find(v => v.month === m);
                    return venta ? parseFloat(venta.total) : 0;
                });
                let comprasData = meses.map(m => {
                    let compra = data.compras.find(c => c.month === m);
                    return compra ? parseFloat(compra.total) : 0;
                });

                // Configuración del gráfico ApexCharts
                let options = {
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    series: [
                        {
                            name: "Ventas",
                            data: ventasData
                        },
                        {
                            name: "Compras",
                            data: comprasData
                        }
                    ],
                    xaxis: {
                        categories: meses.map(m => m.replace('-', '/')),
                        title: { text: "Meses" }
                    },
                    yaxis: {
                        title: { text: "Monto ($)" }
                    },
                    colors: ['#28a745', '#dc3545'],
                    legend: {
                        position: 'top'
                    }
                };

                let chart = new ApexCharts(document.querySelector("#ventasComprasChart"), options);
                chart.render();
            })
            .catch(error => console.error("Error al cargar datos del dashboard:", error));

        fetch("{{ route('dashboard.stats') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalCategorias').innerText = data.totalCategorias;
                document.getElementById('totalProductos').innerText = data.totalProductos;
                document.getElementById('totalCompras').innerText = data.totalCompras;
                document.getElementById('totalVentas').innerText = data.totalVentas;
                document.getElementById('totalUsuarios').innerText = data.totalUsuarios;
            })
            .catch(error => console.error("Error al cargar estadísticas del dashboard:", error));

        fetch("{{ route('dashboard.product-distribution') }}")
            .then(response => response.json())
            .then(data => {
                // Preparar datos para el gráfico de Ventas por Producto
                // Preparar datos para el gráfico de Ventas por Producto
                let productosVentas = data.ventas.map(item => item.producto);
                let valoresVentas = data.ventas.map(item => Number(item.total_vendido)); // Convertir a número

                let optionsVentas = {
                    chart: {
                        type: 'donut',
                        height: 350
                    },
                    series: valoresVentas,
                    labels: productosVentas,
                    colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0'],
                    legend: {
                        position: 'bottom'
                    }
                };

                let ventasChart = new ApexCharts(document.querySelector("#ventasProductosChart"), optionsVentas);
                ventasChart.render();

                // Preparar datos para el gráfico de Compras por Producto
                let productosCompras = data.compras.map(item => item.producto);
                let valoresCompras = data.compras.map(item => Number(item.total_comprado)); // Convertir a número

                let optionsCompras = {
                    chart: {
                        type: 'donut',
                        height: 350
                    },
                    series: valoresCompras,
                    labels: productosCompras,
                    colors: ['#FF5733', '#C70039', '#900C3F', '#581845', '#1E8449'],
                    legend: {
                        position: 'bottom'
                    }
                };

                let comprasChart = new ApexCharts(document.querySelector("#comprasProductosChart"), optionsCompras);
                comprasChart.render();
            })
            .catch(error => console.error("Error al cargar la distribución de productos:", error));

        fetch("{{ route('dashboard.top-customers-suppliers') }}")
            .then(response => response.json())
            .then(data => {
                // Preparar datos para el gráfico de Top Clientes
                let clientes = data.topClientes.map(item => item.cliente);
                let ventasClientes = data.topClientes.map(item => Number(item.total_ventas));

                let optionsClientes = {
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    series: [{
                        name: "Monto de Ventas ($)",
                        data: ventasClientes
                    }],
                    xaxis: {
                        categories: clientes,
                        title: { text: "Clientes" }
                    },
                    yaxis: {
                        title: { text: "Monto ($)" }
                    },
                    colors: ['#008FFB']
                };

                let clientesChart = new ApexCharts(document.querySelector("#topClientesChart"), optionsClientes);
                clientesChart.render();

                // Preparar datos para el gráfico de Top Proveedores
                let proveedores = data.topProveedores.map(item => item.proveedor);
                let comprasProveedores = data.topProveedores.map(item => Number(item.total_compras));

                let optionsProveedores = {
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    series: [{
                        name: "Monto de Compras ($)",
                        data: comprasProveedores
                    }],
                    xaxis: {
                        categories: proveedores,
                        title: { text: "Proveedores" }
                    },
                    yaxis: {
                        title: { text: "Monto ($)" }
                    },
                    colors: ['#FF5733']
                };

                let proveedoresChart = new ApexCharts(document.querySelector("#topProveedoresChart"), optionsProveedores);
                proveedoresChart.render();
            })
            .catch(error => console.error("Error al cargar los datos de clientes y proveedores:", error));
    });
</script>

@endpush


