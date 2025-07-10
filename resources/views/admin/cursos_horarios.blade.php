@extends('recursos.barra')
@section('title', 'Cursos Horarios | Ceinfo')
@section('cursos_horarios')
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
                                    href="{{ route('cursos_horarios') }}" role="tab" aria-controls="overview"
                                    aria-selected="true">Horarios</a>
                            </li>

                        </ul>

                    </div>

                </div>
            </div>
        </div>
        <br>
        <div class="modal fade" id="modal_nuevohorario" tabindex="-1" role="dialog" aria-labelledby="modalLabelHorario"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabelHorario"><b>Nuevo Horario</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('curso_horarios.store') }}" class="forms-sample">
                                    @csrf

                                    <!-- Buscar Curso -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group position-relative">
                                                <label for="searchCurso">Buscar Curso</label>
                                                <div class="input-group align-items-center">
                                                    <input type="text" class="form-control" id="searchCurso"
                                                        name="searchCurso"
                                                        placeholder="Ingrese nombre o nomenclatura del curso" minlength="3"
                                                        autocomplete="off">
                                                    <button type="button" class="clear-search d-none"
                                                        id="clear-curso-search" title="Limpiar búsqueda">&times;</button>
                                                </div>
                                                <input type="hidden" id="id_curso" name="id_curso">
                                                <div id="search-curso-results" class="list-group"
                                                    style="font-size: 0.875rem;"></div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="hora_inicio">Hora de inicio</label>
                                                <input type="time" name="hora_inicio" id="hora_inicio"
                                                    class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="hora_fin">Hora de fin</label>
                                                <input type="time" name="hora_fin" id="hora_fin" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="duracion_meses">Duración (meses)</label>
                                                <input type="number" name="duracion_meses" id="duracion_meses"
                                                    class="form-control" min="1" max="12" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="modalidad">Modalidad</label>
                                                <select name="modalidad" id="modalidad" class="form-select" required>
                                                    <option value="PRESENCIAL">PRESENCIAL</option>
                                                    <option value="VIRTUAL">VIRTUAL</option>
                                                    <option value="HÍBRIDO">HÍBRIDO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="precio_mensual">Precio mensual (S/)</label>
                                                <input type="number" step="0.01" min="0"
                                                    name="precio_mensual" id="precio_mensual" class="form-control"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="estado">Estado</label>
                                                <select name="estado" id="estado" class="form-select" required>
                                                    <option value="ACTIVO" selected>ACTIVO</option>
                                                    <option value="INACTIVO">INACTIVO</option>
                                                    <option value="FINALIZADO">FINALIZADO</option>
                                                    <option value="ESPERA">ESPERA</option>
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

                <h4 class="card-title">Horarios</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_nuevohorario">Agregar</button>



                <br><br>

                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="tablaHorarios" class="table table-sm w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Curso</th>
                                        <th>Docente</th>
                                        <th>Horario</th>
                                        <th>Duración</th>
                                        <th>Modalidad</th>
                                        <th>Precio</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>



    <script>
        $(document).ready(function() {
            let table = $('#tablaHorarios').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('curso_horarios.listar') }}", // asegúrate que esta ruta exista
                    type: "GET",
                },
                order: [
                    [0, 'desc']
                ],
                columns: [{
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1 + meta.settings._iDisplayStart;
                        }
                    },
                    {
                        data: 'nombre_curso'
                    },
                    {
                        data: 'nombre_docente',
                        render: function(docente) {
                            return docente ? docente :
                                '<span class="text-muted">Sin asignar</span>';
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `${data.hora_inicio} - ${data.hora_fin}`;
                        }
                    },
                    {
                        data: 'duracion_meses',
                        render: function(meses) {
                            return `${meses} mes${meses > 1 ? 'es' : ''}`;
                        }
                    },
                    {
                        data: 'modalidad'
                    },
                    {
                        data: 'precio_mensual',
                        render: function(precio) {
                            return `S/ ${parseFloat(precio).toFixed(2)}`;
                        }
                    },
                    {
                        data: 'estado',
                        render: function(estado) {
                            let colores = {
                                'ACTIVO': 'success',
                                'INACTIVO': 'secondary',
                                'FINALIZADO': 'dark',
                                'ESPERA': 'warning'
                            };
                            let clase = colores[estado] || 'secondary';
                            return `<span class="badge bg-${clase}">${estado}</span>`;
                        }
                    },
                    {
                        data: 'id_horario',
                        orderable: false,
                        searchable: false,
                        render: function(id, type, row) {
                            return `
                            <button class="btn btn-sm btn-primary btn-editar-horario" data-id="${id}" title="Editar">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            <form method="POST" action="/curso-horarios/${id}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este horario?')" title="Eliminar">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </form>
                        `;
                        }
                    }
                ],
                language: {
                    paginate: {
                        previous: "<i class='icon-arrow-left'></i>",
                        next: "<i class='icon-arrow-right'></i>",
                        first: "<i class='fas fa-angle-double-left'></i>",
                        last: "<i class='fas fa-angle-double-right'></i>"
                    },
                    lengthMenu: "_MENU_",
                    search: "Buscar:",
                    zeroRecords: `<div class="text-center text-muted fw-bold py-4">
                    <i class="mdi mdi-alert-circle-outline fs-1 d-block mb-2"></i>
                    No se encontraron resultados
                </div>`,
                    emptyTable: `<div class="text-center text-muted fw-bold py-4">
                    <i class="mdi mdi-database-remove fs-1 d-block mb-2"></i>
                    No hay horarios registrados
                </div>`,
                    info: "_START_ - _END_ de _TOTAL_",
                    infoEmpty: "0 a 0 de 0",
                    infoFiltered: "(filtrado de _MAX_ registros totales)"
                },
                dom: '<"d-flex justify-content-between align-items-center"<"left-section"l><"right-section"f>>rtip'
            });

            console.log("✅ Tabla de horarios inicializada");
        });
    </script>

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

    <script>
        $(document).ready(function() {
            // Buscar curso al escribir
            $('#searchCurso').on('keyup', function() {
                let query = $(this).val().trim();

                if (query.length >= 3) {
                    $.ajax({
                        url: "{{ route('cursos.buscar') }}",
                        type: 'GET',
                        data: {
                            query: query
                        },
                        dataType: 'json',
                        success: function(data) {
                            let resultContainer = $('#search-curso-results');
                            resultContainer.html('');

                            if (data.length > 0) {
                                data.forEach(function(item) {
                                    resultContainer.append(`
                                    <a href="#" class="list-group-item list-group-item-action curso-item"
                                        data-id="${item.id_curso}"
                                        data-nombre="${item.nombre_curso}">
                                        ${item.nombre_curso} - ${item.nomenclatura}
                                    </a>
                                `);
                                });
                            } else {
                                resultContainer.html(
                                    '<p class="text-muted p-2">No se encontraron cursos</p>'
                                );
                            }
                        },
                        error: function(xhr) {
                            $('#search-curso-results').html(
                                '<p class="text-danger p-2">Error en la búsqueda</p>');
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    $('#search-curso-results').html('');
                }
            });

            // Seleccionar curso
            $(document).on('click', '.curso-item', function(e) {
                e.preventDefault();

                $('#searchCurso').val($(this).data('nombre'));
                $('#id_curso').val($(this).data('id'));
                $('#search-curso-results').html('');
                $('#searchCurso').prop('disabled', true);
                $('#clear-curso-search').removeClass('d-none');
            });

            // Limpiar búsqueda
            $('#clear-curso-search').on('click', function() {
                $('#searchCurso').val('').prop('disabled', false).focus();
                $('#id_curso').val('');
                $('#clear-curso-search').addClass('d-none');
            });

            // Al cerrar modal (si lo usas en uno)
            $('#modal_nuevohorario').on('hidden.bs.modal', function() {
                $('#searchCurso').val('').prop('disabled', false);
                $('#id_curso').val('');
                $('#search-curso-results').html('');
                $('#clear-curso-search').addClass('d-none');
            });
        });
    </script>



@endsection
