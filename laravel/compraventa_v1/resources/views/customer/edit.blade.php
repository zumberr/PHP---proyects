@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Editar Cliente</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Mantenimiento</a></li>
                            <li class="breadcrumb-item active">Clientes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="container mt-4">
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary mb-3">Volver al listado</a>

                        <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="ruc" class="form-label">RUC</label>
                                <input type="text" name="ruc" class="form-control" id="ruc" value="{{ $customer->ruc }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ $customer->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control" id="email" value="{{ $customer->email }}">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="text" name="phone" class="form-control" id="phone" value="{{ $customer->phone }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Dirección</label>
                                <textarea name="address" class="form-control" id="address">{{ $customer->address }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="photo" class="form-label">Foto</label>
                                <input type="file" name="photo" class="form-control" id="photo">
                                @if ($customer->photo)
                                    <img src="{{ asset('storage/' . $customer->photo) }}" class="img-thumbnail mt-2" width="150">
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Estado</label>
                                <select name="status" class="form-control" id="status" required>
                                    <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                </select>
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
        $('#status').select2({
            width: '100%' // Asegura el ancho correcto
        });
    });
</script>
@endpush

