<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="Sistema de Gestión de Compras y Ventas" name="description">
<meta content="AnderCode" name="author">
<title>@yield('title', 'AnderCode - Sistema de Compra y Venta')</title>

<!-- Icono del sitio -->
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Scripts de configuración -->
<script src="{{ asset('assets/js/layout.js') }}"></script>

<!-- Archivos CSS -->
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css">

