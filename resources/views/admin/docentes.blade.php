@extends('recursos.barra')
@section('title', 'Lista Docentes | Ceinfo')
@section('docentes')

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
                                <a class="nav-link  ps-0" id="home-tab" href="">Docentes</a>
                            </li>
                            <li class="nav-item mx-2">
                                <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab"
                                    href="{{ route('docentes') }}" role="tab" aria-controls="overview"
                                    aria-selected="true">Lista</a>
                            </li>

                        </ul>

                    </div>

                </div>
            </div>
        </div>
        <br>

        <div class="modal fade" id="modal_nuevo_docente" tabindex="-1" aria-labelledby="modalDocenteLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title"><b>Registrar Docente</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="{{ route('docentes.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Buscar Persona -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group position-relative">
                                        <label for="search">Buscar Persona</label>
                                        <div class="input-group align-items-center">
                                            <input type="text" class="form-control" id="search" name="search"
                                                placeholder="Ingrese DNI, nombre o apellido" minlength="4"
                                                autocomplete="off">
                                            <button type="button" class="clear-search d-none" id="clear-search"
                                                title="Limpiar búsqueda">
                                                &times;
                                            </button>
                                        </div>
                                        <input type="hidden" id="id_persona" name="id_persona">
                                        <div id="search-results" class="list-group" style="font-size: 0.875rem;">
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Especialidad y Grado Académico en una misma fila -->
                            <div class="row">
                                <div class="col-md-6 form-group mt-3">
                                    <label for="especialidad">Especialidad</label>
                                    <input type="text" class="form-control" name="especialidad" id="especialidad"
                                        required>
                                </div>

                                <div class="col-md-6 form-group mt-3">
                                    <label for="grado_academico">Grado Académico</label>
                                    <input type="text" class="form-control" name="grado_academico" id="grado_academico"
                                        required>
                                </div>
                            </div>


                            <!-- CV -->
                            <div class="form-group mt-3">
                                <label for="cv_url">Currículum Vitae (PDF)</label>
                                <input type="file" class="form-control" name="cv_url" id="cv_url" accept=".pdf">
                            </div>

                            <!-- Foto -->
                            <div class="form-group mt-3">
                                <label for="foto_docente">Foto</label>
                                <input type="file" class="dropify" name="foto" id="foto_docente" accept="image/*"
                                    data-height="150" />
                            </div>

                            <!-- Botones -->
                            <div class="form-group mt-4 text-end">
                                <button type="submit" class="btn btn-primary" id="btn_registrar_docente">
                                    Registrar
                                </button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_editar_docente" tabindex="-1" aria-labelledby="modalEditarDocenteLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title"><b>Editar Docente</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" id="formEditarDocente" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="id_docente" id="edit_id_docente">
                            <input type="hidden" name="id_persona" id="edit_id_persona_docente">

                            <div class="row">
                                <div class="col-md-6 form-group mt-3">
                                    <label for="edit_documento_docente">Documento</label>
                                    <input type="text" class="form-control" id="edit_documento_docente" readonly>
                                </div>

                                <div class="col-md-6 form-group mt-3">
                                    <label for="edit_nombres_docente">Nombres</label>
                                    <input type="text" class="form-control" id="edit_nombres_docente" readonly>
                                </div>
                            </div>

                            <!-- Especialidad y Grado Académico -->
                            <div class="row">
                                <div class="col-md-6 form-group mt-3">
                                    <label for="edit_especialidad">Especialidad</label>
                                    <input type="text" class="form-control" name="especialidad"
                                        id="edit_especialidad" required>
                                </div>

                                <div class="col-md-6 form-group mt-3">
                                    <label for="edit_grado_academico">Grado Académico</label>
                                    <input type="text" class="form-control" name="grado_academico"
                                        id="edit_grado_academico" required>
                                </div>
                            </div>


                            <!-- CV y estado -->
                            <div class="row">
                                <div class="col-md-8 form-group mt-3">
                                    <label for="edit_cv_url">CV (PDF)</label>
                                    <input type="file" class="form-control" name="cv_url" id="edit_cv_url"
                                        accept=".pdf">
                                </div>

                                <div class="col-md-4 form-group mt-3">
                                    <label for="edit_estado_docente">Estado</label>
                                    <select class="form-select" name="estado" id="edit_estado_docente" required>
                                        <option value="ACTIVO">ACTIVO</option>
                                        <option value="INACTIVO">INACTIVO</option>
                                        <option value="INHABILITADO">INHABILITADO</option>
                                        <option value="SUSPENDIDO">SUSPENDIDO</option>
                                        <option value="RETIRADO">RETIRADO</option>
                                    </select>
                                </div>

                            </div>

                            <!-- Foto -->
                            <div class="form-group mt-3">
                                <label for="edit_foto_docente">Foto</label>
                                <input type="file" class="dropify" name="foto" id="edit_foto_docente"
                                    accept="image/*" data-height="150">
                            </div>

                            <!-- Botones -->
                            <div class="form-group mt-4 text-end">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modal_ver_docente" tabindex="-1" aria-labelledby="modalVerDocenteLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" style="max-width: 900px;">
                <div class="modal-content border-0 shadow rounded-3">
                    <div class="modal-header bg-primary text-white py-2 px-3">
                        <h6 class="modal-title fw-bold mb-0" id="modalVerDocenteLabel">Información del Docente</h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body px-3 py-2">
                        <div class="row g-2">
                            <!-- Foto e Identidad -->
                            <div class="col-4 d-flex flex-column align-items-center text-center">
                                <img id="ver_foto_docente" class="img-fluid rounded-circle border shadow-sm mb-2"
                                    alt="Foto" width="90" height="90" style="object-fit: cover;">
                                <div id="ver_nombre_completo_docente" class="fw-semibold small"></div>
                                <span id="ver_estado_docente" class="badge bg-success small mt-1 px-2 py-1"></span>
                            </div>

                            <!-- Datos -->
                            <div class="col-8">
                                <div class="row g-2 small">
                                    <div class="col-12 border-bottom pb-1 mb-2 fw-semibold text-primary">Datos del Docente
                                    </div>

                                    <div class="col-6">
                                        <label class="fw-semibold mb-0">Documento:</label>
                                        <div id="ver_documento_docente" class="text-muted"></div>
                                    </div>

                                    <div class="col-6">
                                        <label class="fw-semibold mb-0">Especialidad:</label>
                                        <div id="ver_especialidad_docente" class="text-muted"></div>
                                    </div>

                                    <div class="col-6">
                                        <label class="fw-semibold mb-0">Grado Académico:</label>
                                        <div id="ver_grado_academico_docente" class="text-muted"></div>
                                    </div>

                                    <div class="col-6">
                                        <label class="fw-semibold mb-0">CV:</label>
                                        <div>
                                            <a id="ver_cv_url_docente" class="small" target="_blank">Sin CV</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div> <!-- /.modal-body -->
                </div>
            </div>
        </div>







        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Docentes</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_nuevo_docente">Registrar</button>


                <br><br>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="tablaDocentes" class="table table-sm w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Foto</th>
                                        <th>Documento</th>
                                        <th>Nombre completo</th>
                                        <th>Especialidad</th>
                                        <th>Grado Académico</th>
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
            let table = $('#tablaDocentes').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('docentes.listar') }}",
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
                        data: 'foto',
                        orderable: false,
                        searchable: false,
                        render: function(foto) {
                            let src = foto ? `/storage/${foto}` : '/images/default-avatar.png';
                            return `<img src="${src}" alt="foto" class="rounded-circle" width="40" height="40">`;
                        }
                    },
                    {
                        data: 'documento'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `${row.nombres} ${row.apellido_paterno} ${row.apellido_materno}`;
                        }
                    },
                    {
                        data: 'especialidad'
                    },
                    {
                        data: 'grado_academico'
                    },
                    {
                        data: 'estado',
                        render: function(estado) {
                            let colores = {
                                'ACTIVO': 'success',
                                'INACTIVO': 'secondary',
                                'INHABILITADO': 'dark',
                                'SUSPENDIDO': 'warning',
                                'RETIRADO': 'danger'
                            };
                            let clase = colores[estado] || 'secondary';
                            return `<span class="badge bg-${clase}">${estado}</span>`;
                        }
                    },

                    {
                        data: 'id_docente',
                        orderable: false,
                        searchable: false,
                        render: function(id, type, row) {
                            let foto = row.foto ? `/storage/${row.foto}` :
                                '/images/default-avatar.png';
                            let nombreCompleto =
                                `${row.nombres} ${row.apellido_paterno} ${row.apellido_materno}`;

                            return `
                            <button type="button" class="btn btn-info shadow btn-xs sharp me-1 btn-ver-docente"
                                title="Ver"
                                data-id="${row.id_docente}"
                                data-nombre="${nombreCompleto}"
                                data-documento="${row.documento}"
                                data-especialidad="${row.especialidad}"
                                data-grado_academico="${row.grado_academico}"
                                data-cv_url="${row.cv_url}"
                                data-estado="${row.estado}"
                                data-foto="${foto}">
                                <i class="mdi mdi-eye"></i>
                            </button>

                            <button type="button" class="btn btn-primary shadow btn-xs sharp me-1 btn-editar-docente"
                                title="Editar"
                                data-id="${row.id_docente}"
                                data-id_persona="${row.id_persona}"
                                data-documento="${row.documento}"
                                data-nombre="${nombreCompleto}"
                                data-especialidad="${row.especialidad}"
                                data-grado_academico="${row.grado_academico}"
                                data-cv_url="${row.cv_url}"
                                data-estado="${row.estado}"
                                data-foto="${row.foto}">
                                <i class="mdi mdi-pencil"></i>
                            </button>

                            <form method="POST" action="/docentes/${row.id_docente}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger shadow btn-xs sharp me-1"
                                    onclick="return confirm('¿Eliminar este docente?')">
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
                        No hay docentes registrados
                    </div>`,
                    info: "_START_ - _END_ de _TOTAL_",
                    infoEmpty: "0 a 0 de 0",
                    infoFiltered: "(filtrado de _MAX_ registros totales)"
                },
                dom: '<"d-flex justify-content-between align-items-center"<"left-section"l><"right-section"f>>rtip'
            });

            console.log("✅ Tabla de docentes inicializada");
        });
    </script>
    <script>
        $(document).ready(function() {
            // Buscar persona cuando se escribe en el input
            $('#search').on('keyup', function() {
                let query = $(this).val().trim();

                if (query.length >= 4) {
                    $.ajax({
                        url: "{{ route('personas.buscar') }}",
                        type: 'GET',
                        data: {
                            query: query
                        },
                        dataType: 'json',
                        success: function(data) {
                            let resultContainer = $('#search-results');
                            resultContainer.html('');

                            if (data.length > 0) {
                                data.forEach(function(item) {
                                    resultContainer.append(`
                                        <a href="#" class="list-group-item list-group-item-action result-item"
                                            data-id="${item.id_persona}"
                                            data-correo="${item.correo}">
                                            ${item.nombres} ${item.apellido_paterno} ${item.apellido_materno} - ${item.documento}
                                        </a>
                                    `);
                                });

                            } else {
                                resultContainer.html(
                                    '<p class="text-muted p-2">No se encontraron resultados</p>'
                                );
                            }
                        },
                        error: function(xhr) {
                            $('#search-results').html(
                                '<p class="text-danger p-2">Error en la búsqueda</p>');
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    $('#search-results').html('');
                }
            });

            // Seleccionar persona del resultado
            // Al seleccionar un resultado
            $(document).on('click', '.result-item', function(e) {
                e.preventDefault();

                $('#search').val($(this).text());
                $('#id_persona').val($(this).data('id'));
                $('#email').val($(this).data('correo') || '');
                $('#search-results').html('');
                $('#search').prop('disabled', true);
                $('#clear-search').removeClass('d-none'); // Mostrar botón "X"
                validarFormulario();
            });

            // Al presionar el botón "X"
            $('#clear-search').on('click', function() {
                $('#search').val('').prop('disabled', false).focus();
                $('#id_persona').val('');
                $('#clear-search').addClass('d-none');

            });

            // Al cerrar el modal
            $('#modal_nuevo_docente').on('hidden.bs.modal', function() {
                const form = $(this).find('form')[0];
                form.reset();

                // Limpiar búsqueda
                $('#search').prop('disabled', false).val('');
                $('#search-results').html('');
                $('#id_persona').val('');

                // Ocultar y limpiar campos condicionales
                $('#grupo_codigo').addClass('d-none');
                $('#grupo_carrera').addClass('d-none');
                $('#codigo_estudiante').val('').removeAttr('required');
                $('#id_carrera').val('').removeAttr('required');

                // Ocultar el botón de limpiar búsqueda
                $('#clear-search').addClass('d-none');

                // Resetear Dropify
                const dropify = $('#foto').data('dropify');
                if (dropify) dropify.resetPreview().clearElement();
            });


        });
    </script>
    <script>
        $(document).on('click', '.btn-editar-docente', function() {
            const docente = $(this).data();

            // Asignar campos ocultos y de texto
            $('#edit_id_docente').val(docente.id);
            $('#edit_id_persona_docente').val(docente.id_persona);
            $('#edit_documento_docente').val(docente.documento);
            $('#edit_nombres_docente').val(docente.nombre);
            $('#edit_especialidad').val(docente.especialidad);
            $('#edit_grado_academico').val(docente.grado_academico);
            $('#edit_estado_docente').val(docente.estado);

            // Establecer acción del formulario con método PUT hacia /docentes/{id}
            $('#formEditarDocente').attr('action', `/docentes/${docente.id}`);

            // Foto - preparar ruta válida
            let foto = docente.foto || 'docentes/fotos/docente.png';
            if (!foto.startsWith('/storage') && !foto.startsWith('http')) {
                foto = `/storage/${foto}`;
            }

            // Actualizar Dropify con nueva foto
            let drEvent = $('#edit_foto_docente').dropify({
                defaultFile: foto
            });

            drEvent = drEvent.data('dropify');
            drEvent.resetPreview();
            drEvent.clearElement();
            drEvent.settings.defaultFile = foto;
            drEvent.destroy();
            drEvent.init();

            // Mostrar modal
            $('#modal_editar_docente').modal('show');
        });
    </script>




    <script>
        $(document).on('click', '.btn-ver-docente', function() {
            const nombreCompleto = $(this).data('nombre');
            const documento = $(this).data('documento');
            const especialidad = $(this).data('especialidad');
            const gradoAcademico = $(this).data('grado_academico');
            const cvUrl = $(this).data('cv_url');
            const estado = $(this).data('estado');

            // Procesar foto
            let foto = $(this).data('foto');
            if (!foto || foto === '') {
                foto = '/images/default-avatar.png';
            } else if (!foto.startsWith('/storage') && !foto.startsWith('http')) {
                foto = `/storage/${foto}`;
            }

            // Actualizar contenido del modal
            $('#ver_nombre_completo_docente').text(nombreCompleto);
            $('#ver_documento_docente').text(documento);
            $('#ver_especialidad_docente').text(especialidad);
            $('#ver_grado_academico_docente').text(gradoAcademico);
            $('#ver_foto_docente').attr('src', foto);

            // Mostrar enlace del CV o mensaje por defecto
            if (cvUrl && cvUrl !== '') {
                $('#ver_cv_url_docente')
                    .attr('href', `/storage/${cvUrl}`)
                    .removeClass('text-muted')
                    .addClass('text-primary')
                    .text('Ver CV');
            } else {
                $('#ver_cv_url_docente')
                    .removeAttr('href')
                    .removeClass('text-primary')
                    .addClass('text-muted')
                    .text('Sin CV');
            }

            // Estado visual
            const colores = {
                'ACTIVO': 'success',
                'INACTIVO': 'secondary',
                'INHABILITADO': 'dark',
                'SUSPENDIDO': 'warning',
                'RETIRADO': 'danger'
            };
            const claseEstado = colores[estado] || 'secondary';
            $('#ver_estado_docente')
                .removeClass()
                .addClass(`badge bg-${claseEstado} small mt-1 px-2 py-1`)
                .text(estado);

            // Mostrar modal
            $('#modal_ver_docente').modal('show');
        });
    </script>



@endsection
