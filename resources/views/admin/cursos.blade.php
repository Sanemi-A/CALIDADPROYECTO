@extends('recursos.barra')
@section('title', 'Cursos | Ceinfo')
@section('cursos')
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
                                <a class="nav-link  ps-0" id="home-tab" href="">Cursos</a>
                            </li>
                            <li class="nav-item mx-2">
                                <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab"
                                    href="{{ route('cursos') }}" role="tab" aria-controls="overview"
                                    aria-selected="true">Lista</a>
                            </li>

                        </ul>

                    </div>

                </div>
            </div>
        </div>
        <br>
        <div class="modal fade" id="modal_nuevocurso" tabindex="-1" role="dialog" aria-labelledby="modalLabelCurso"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabelCurso"><b>Nuevo Curso</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('cursos.store') }}" class="forms-sample">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nombre_curso">Nombre del Curso</label>
                                                <input type="text" class="form-control" id="nombre_curso"
                                                    name="nombre_curso" placeholder="Ej: Ofimática Básica" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nomenclatura">Nomenclatura</label>
                                                <input type="text" class="form-control" id="nomenclatura"
                                                    name="nomenclatura" placeholder="Ej: INF101" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="id_programa">Programa</label>
                                                <select class="form-select" id="id_programa" name="id_programa" required>
                                                    <option value="" disabled selected>Seleccione un programa</option>
                                                    @foreach ($programas as $programa)
                                                        <option value="{{ $programa->id_programa }}">{{ $programa->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="id_nivel">Nivel</label>
                                                <select class="form-select" id="id_nivel" name="id_nivel" required>
                                                    <option value="" disabled selected>Seleccione un nivel</option>
                                                    @foreach ($niveles as $nivel)
                                                        <option value="{{ $nivel->id_nivel }}">{{ $nivel->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="estado">Estado</label>
                                                <select class="form-select" id="estado" name="estado" required>
                                                    <option value="ACTIVO" selected>ACTIVO</option>
                                                    <option value="INACTIVO">INACTIVO</option>
                                                    <option value="CULMINADO">CULMINADO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary me-2">Registrar</button>
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

        <div class="modal fade" id="modal_editarcurso" tabindex="-1" role="dialog"
            aria-labelledby="modalLabelEditarCurso" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabelEditarCurso"><b>Editar Curso</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="formEditarCurso">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="id" id="editar_id">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editar_nombre_curso">Nombre del Curso</label>
                                                <input type="text" class="form-control" id="editar_nombre_curso"
                                                    name="nombre_curso" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editar_nomenclatura">Nomenclatura</label>
                                                <input type="text" class="form-control" id="editar_nomenclatura"
                                                    name="nomenclatura" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editar_id_programa">Programa</label>
                                                <select class="form-select" id="editar_id_programa" name="id_programa"
                                                    required>
                                                    <option value="" disabled>Seleccione un programa</option>
                                                    @foreach ($programas as $programa)
                                                        <option value="{{ $programa->id_programa }}">
                                                            {{ $programa->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editar_id_nivel">Nivel</label>
                                                <select class="form-select" id="editar_id_nivel" name="id_nivel"
                                                    required>
                                                    <option value="" disabled>Seleccione un nivel</option>
                                                    @foreach ($niveles as $nivel)
                                                        <option value="{{ $nivel->id_nivel }}">{{ $nivel->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editar_estado">Estado</label>
                                                <select class="form-select" id="editar_estado" name="estado" required>
                                                    <option value="ACTIVO">ACTIVO</option>
                                                    <option value="INACTIVO">INACTIVO</option>
                                                    <option value="CULMINADO">CULMINADO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12 text-end">
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

                <h4 class="card-title">Cursos</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_nuevocurso">Agregar</button>



                <br><br>

                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre del Curso</th>
                                        <th>Nomenclatura</th>
                                        <th>Programa</th>
                                        <th>Nivel</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cursos as $curso)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $curso->nombre_curso }}</td>
                                            <td>{{ $curso->nomenclatura }}</td>
                                            <td>{{ $curso->programa->nombre ?? '—' }}</td>
                                            <td>{{ $curso->nivel->nombre ?? '—' }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $curso->estado == 'ACTIVO' ? 'success' : ($curso->estado == 'INACTIVO' ? 'secondary' : 'warning') }}">
                                                    {{ $curso->estado }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-primary shadow btn-xs sharp me-1 btn-editar-curso"
                                                    data-id="{{ $curso->id_curso }}"
                                                    data-nombre="{{ $curso->nombre_curso }}"
                                                    data-nomenclatura="{{ $curso->nomenclatura }}"
                                                    data-programa="{{ $curso->id_programa }}"
                                                    data-nivel="{{ $curso->id_nivel }}"
                                                    data-estado="{{ $curso->estado }}" data-bs-toggle="modal"
                                                    data-bs-target="#modal_editarcurso">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>


                                                <!-- Formulario eliminar -->
                                                <form action="{{ route('cursos.destroy', $curso->id_curso) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger shadow btn-xs sharp me-1"
                                                        onclick="return confirm('¿Estás seguro de eliminar este curso?')">
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
            // Selecciona todos los botones de editar
            const botonesEditar = document.querySelectorAll('.btn-editar-rol');

            botonesEditar.forEach(boton => {
                boton.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const nombre = this.getAttribute('data-nombre');

                    // Rellenar el campo del formulario con el nombre
                    document.getElementById('editar_nombre').value = nombre;

                    // Actualizar la acción del formulario
                    const form = document.getElementById('form_editar');
                    form.action = `/roles/${id}`;
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const botonesEditar = document.querySelectorAll('.btn-editar-curso');

            botonesEditar.forEach(boton => {
                boton.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nombre = this.dataset.nombre;
                    const nomenclatura = this.dataset.nomenclatura;
                    const programa = this.dataset.programa;
                    const nivel = this.dataset.nivel;
                    const estado = this.dataset.estado;

                    document.getElementById('editar_id').value = id;
                    document.getElementById('editar_nombre_curso').value = nombre;
                    document.getElementById('editar_nomenclatura').value = nomenclatura;
                    document.getElementById('editar_id_programa').value = programa;
                    document.getElementById('editar_id_nivel').value = nivel;
                    document.getElementById('editar_estado').value = estado;

                    // Cambiar acción del formulario
                    const form = document.getElementById('formEditarCurso');
                    form.action = `/cursos/${id}`;
                });
            });
        });
    </script>


@endsection
