@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Crear Nueva Categoría</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Mantenimiento</a></li>
                                <li class="breadcrumb-item active">Categoria</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="container mt-4">
                            <a href="{{ route('categorias.index') }}" class="btn btn-secondary mb-3">Volver al listado</a>

                            <form action="{{ route('categorias.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre de la Categoría</label>
                                    <input type="text" name="name" class="form-control" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descripción</label>
                                    <textarea name="description" class="form-control" id="description"></textarea>
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

