@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Editar Producto</h4>

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

                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ $product->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea name="description" class="form-control" id="description">{{ $product->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Precio</label>
                                <input type="number" name="price" class="form-control" id="price" step="0.01" value="{{ $product->price }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Cantidad</label>
                                <input type="number" name="quantity" class="form-control" id="quantity" value="{{ $product->quantity }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Categoría</label>
                                <select name="category_id" class="form-select" id="category_id" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Estado</label>
                                <select name="status" class="form-select" id="status" required>
                                    <option value="available" {{ $product->status == 'available' ? 'selected' : '' }}>Disponible</option>
                                    <option value="sold" {{ $product->status == 'sold' ? 'selected' : '' }}>Vendido</option>
                                    <option value="archived" {{ $product->status == 'archived' ? 'selected' : '' }}>Archivado</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">Actualizar Imágenes</label>
                                <input type="file" name="images[]" class="form-control" id="images" multiple>
                                <small class="text-muted">Puedes cargar nuevas imágenes para reemplazar las existentes.</small>
                                <div class="mt-3">
                                    <h6>Imágenes Actuales:</h6>
                                    <div class="row">
                                        @foreach ($product->images as $image)
                                            <div class="col-md-2 mb-3 text-center" id="image-{{ $image->id }}">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail" width="100" alt="Imagen del producto">
                                                <button type="button" class="btn btn-danger btn-sm mt-1 delete-image-btn" data-id="{{ $image->id }}">Eliminar</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
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

    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll('.delete-image-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const imageId = this.getAttribute('data-id');
                const url = `{{ url('product-images') }}/${imageId}`;

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción eliminará la imagen de forma permanente.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Eliminar la imagen del DOM
                                document.getElementById(`image-${imageId}`).remove();
                                Swal.fire(
                                    '¡Eliminada!',
                                    'La imagen se ha eliminado correctamente.',
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Error',
                                    'No se pudo eliminar la imagen. Inténtalo nuevamente.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error al eliminar la imagen:', error);
                            Swal.fire(
                                'Error',
                                'Ocurrió un problema al procesar la solicitud.',
                                'error'
                            );
                        });
                    }
                });
            });
        });
    });
</script>
@endpush
