@extends('layouts.app')

@section('title', 'Registrar Producto')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Registrar Nuevo Producto</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Mantenimiento</a></li>
                            <li class="breadcrumb-item active">Productos</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="container mt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">Volver al listado</a>

                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea name="description" class="form-control" id="description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Precio</label>
                                <input type="number" name="price" class="form-control" id="price" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Cantidad</label>
                                <input type="number" name="quantity" class="form-control" id="quantity" required>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Categoría</label>
                                <select name="category_id" class="form-select" id="category_id" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Estado</label>
                                <select name="status" class="form-select" id="status" required>
                                    <option value="available">Disponible</option>
                                    <option value="sold">Vendido</option>
                                    <option value="archived">Archivado</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">Imágenes</label>
                                <input type="file" name="images[]" class="form-control" id="images" multiple>
                                <small class="text-muted">Puedes cargar más de una imagen (formatos: jpeg, png, jpg, gif).</small>
                            </div>
                            <button type="submit" class="btn btn-success">Guardar</button>
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
    $(document).ready(function() {
        $('#category_id').select2({
            width: '100%' // Asegura el ancho correcto
        });

        $('#status').select2({
            width: '100%' // Asegura el ancho correcto
        });
    });
</script>
@endpush
