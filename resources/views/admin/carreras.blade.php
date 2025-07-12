@extends('recursos.barra')
@section('title', 'Carreras | Ceinfo')
@section('carreras')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item mx-2">
                                <a class="nav-link  ps-0" id="home-tab" href="{{ route('inicio') }}">Inicio</a>
                            </li>
                            <li class="nav-item mx-2">
                                <a class="nav-link  ps-0" id="home-tab" href="">Parametros</a>
                            </li>
                            <li class="nav-item mx-2">
                                <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab"
                                    href="{{ route('carreras') }}" role="tab" aria-controls="overview"
                                    aria-selected="true">Carreras</a>
                            </li>

                        </ul>

                    </div>

                </div>
            </div>
        </div>
        <br>
        <div class="modal fade" id="modal_carrera" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;" role="document">
                <div class="modal-content">
                    <!-- Encabezado del modal -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Nuevo registro de carrera</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Cuerpo del modal con el formulario -->
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">

                                <form class="forms-sample" method="POST" action="{{ route('carreras.store') }}">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="nombre_carrera">Nombre de la carrera</label>
                                                <input type="text" class="form-control" id="nombre_carrera"
                                                    placeholder="Nombre de la carrera" name="nombre" maxlength="100"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="prefijo">Prefijo</label>
                                                <input type="text" class="form-control" id="prefijo" name="prefijo"
                                                    placeholder="Ejemplo ISI" maxlength="5" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary me-2">Agregar</button>
                                            <button type="reset" data-bs-dismiss="modal"
                                                class="btn btn-light">Cancelar</button>
                                        </div>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="modal fade" id="modal_editar_carrera" tabindex="-1" role="dialog"
            aria-labelledby="modalEditarCarreraLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;" role="document">
                <div class="modal-content">
                    <!-- Encabezado -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarCarreraLabel"><b>Editar carrera</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Cuerpo del modal -->
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form class="forms-sample" id="formEditarCarrera" method="POST" action="">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="id_carrera" id="id_carrera">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editar_nombre_carrera">Nombre de la carrera</label>
                                                <input type="text" class="form-control" id="editar_nombre_carrera"
                                                    name="nombre" maxlength="100" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editar_prefijo">Prefijo</label>
                                                <input type="text" class="form-control" id="editar_prefijo"
                                                    name="prefijo" maxlength="5" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary me-2">Actualizar</button>
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>




        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Carreras Profesionales</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_carrera">Agregar</button>



                <br><br>

                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre de la carrera</th>
                                        <th>Prefijo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carreras as $carrera)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $carrera->nombre }}</td>
                                            <td>{{ $carrera->prefijo }}</td>
                                            <td>
                                                <!-- Botón Editar -->
                                                <a href="#"
                                                    class="btn btn-primary shadow btn-xs sharp me-1 btn-editar-carrera"
                                                    data-id="{{ $carrera->id_carrera }}"
                                                    data-nombre="{{ $carrera->nombre }}"
                                                    data-prefijo="{{ $carrera->prefijo }}" data-bs-toggle="modal"
                                                    data-bs-target="#modal_editar_carrera">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>

                                                <!-- Formulario Eliminar -->
                                                <form action="{{ route('carreras.destroy', $carrera->id_carrera) }}"
                                                    method="POST" style="display:inline;" class="form-eliminar-carrera"
                                                    data-nombre="{{ $carrera->nombre }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger shadow btn-xs sharp me-1">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </form>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttonsEditar = document.querySelectorAll('.btn-editar-carrera');
            const formEditar = document.getElementById('formEditarCarrera');

            buttonsEditar.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const nombre = this.getAttribute('data-nombre');
                    const prefijo = this.getAttribute('data-prefijo');

                    // Llenar los campos del formulario
                    document.getElementById('id_carrera').value = id;
                    document.getElementById('editar_nombre_carrera').value = nombre;
                    document.getElementById('editar_prefijo').value = prefijo;

                    // Actualizar la acción del formulario con la ruta RESTful correcta
                    formEditar.action = `/carreras/${id}`;
                });
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formsEliminarCarrera = document.querySelectorAll('.form-eliminar-carrera');

            formsEliminarCarrera.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const carreraNombre = form.getAttribute('data-nombre');
                    const mensaje =
                        `¡Atención!\nSe eliminará la carrera "${carreraNombre}" y todos los datos relacionados.\n\nPara confirmar, escribe la palabra "eliminar" (sin comillas):`;

                    const confirmacion = prompt(mensaje);

                    if (confirmacion && confirmacion.toLowerCase() === 'eliminar') {
                        form.submit();
                    } else {
                        alert(' Confirmación incorrecta. La carrera no fue eliminada.');
                    }
                });
            });
        });
    </script>


@endsection
