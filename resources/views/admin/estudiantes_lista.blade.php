@extends('recursos.barra')
@section('title', 'Lista Estudiantes | Ceinfo')
@section('estudiantes_lista')

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
                                <a class="nav-link  ps-0" id="home-tab" href="">Estudiantes</a>
                            </li>
                            <li class="nav-item mx-2">
                                <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab"
                                    href="{{ route('estudiantes') }}" role="tab" aria-controls="overview"
                                    aria-selected="true">Lista</a>
                            </li>

                        </ul>

                    </div>

                </div>
            </div>
        </div>
        <br>

        <div class="modal fade" id="modal_nuevo_estudiante" tabindex="-1" aria-labelledby="modalEstudianteLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title"><b>Registrar Estudiante</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="{{ route('estudiantes.store') }}" enctype="multipart/form-data">
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

                            <!-- Tipo de Alumno -->
                            <div class="form-group mt-3">
                                <label for="id_tipo_alumno">Tipo de Alumno</label>
                                <select class="form-select" name="id_tipo_alumno" id="id_tipo_alumno" required>
                                    <option value="" disabled selected>Seleccione tipo de alumno</option>
                                    @foreach ($TipoAlumno as $tipo)
                                        <option value="{{ $tipo->id_tipo_alumno }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <!-- Código de Estudiante -->
                                <div class="form-group mt-3 d-none col-md-6" id="grupo_codigo">
                                    <label for="codigo_estudiante">Código del Estudiante</label>
                                    <input type="text" class="form-control" name="codigo_estudiante"
                                        id="codigo_estudiante" required>
                                </div>

                                <!-- Carrera -->
                                <div class="form-group mt-3 d-none col-md-6" id="grupo_carrera">
                                    <label for="id_carrera">Carrera</label>
                                    <select class="form-select" name="id_carrera" id="id_carrera">
                                        <option value="" disabled selected>Seleccione una carrera</option>
                                        @foreach ($Carrera as $carrera)
                                            <option value="{{ $carrera->id_carrera }}">{{ $carrera->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <!-- Foto -->
                            <div class="form-group mt-3">
                                <label for="foto">Foto</label>
                                <input type="file" class="dropify" name="foto" id="foto" accept="image/*"
                                    data-height="150" />
                            </div>

                            <!-- Botones -->
                            <div class="form-group mt-4 text-end">
                                <button type="submit" class="btn btn-primary" id="btn_registrar_estudiante">Registrar
                                    Estudiante</button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_editar_estudiante" tabindex="-1" aria-labelledby="modalEditarEstudianteLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title"><b>Editar Estudiante</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" id="formEditarEstudiante" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="id_estudiante" id="edit_id_estudiante">
                            <input type="hidden" name="id_persona" id="edit_id_persona">

                            <div class="row">
                                <div class="col-md-6 form-group mt-3">
                                    <label for="edit_documento">Documento</label>
                                    <input type="text" class="form-control" id="edit_documento" readonly>
                                </div>

                                <div class="col-md-6 form-group mt-3">
                                    <label for="edit_nombres">Nombres</label>
                                    <input type="text" class="form-control" id="edit_nombres" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mt-3">
                                    <label for="edit_apellidos">Apellidos</label>
                                    <input type="text" class="form-control" id="edit_apellidos" readonly>
                                </div>

                                <div class="col-md-6 form-group mt-3">
                                    <label for="edit_id_tipo_alumno">Tipo de Alumno</label>
                                    <select class="form-select" name="id_tipo_alumno" id="edit_id_tipo_alumno" required>
                                        <option value="" disabled selected>Seleccione tipo de alumno</option>
                                        @foreach ($TipoAlumno as $tipo)
                                            <option value="{{ $tipo->id_tipo_alumno }}">{{ $tipo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mt-3 d-none" id="edit_grupo_codigo">
                                    <label for="edit_codigo_estudiante">Código del Estudiante</label>
                                    <input type="text" class="form-control" name="codigo_estudiante"
                                        id="edit_codigo_estudiante">
                                </div>

                                <div class="col-md-6 form-group mt-3 d-none" id="edit_grupo_carrera">
                                    <label for="edit_id_carrera">Carrera</label>
                                    <select class="form-select" name="id_carrera" id="edit_id_carrera">
                                        <option value="" disabled selected>Seleccione una carrera</option>
                                        @foreach ($Carrera as $carrera)
                                            <option value="{{ $carrera->id_carrera }}">{{ $carrera->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 form-group mt-3">
                                    <label for="edit_estado">Estado</label>
                                    <select class="form-select" name="estado" id="edit_estado">
                                        <option value="ACTIVO">ACTIVO</option>
                                        <option value="INACTIVO">INACTIVO</option>
                                    </select>
                                </div>

                                <div class="col-md-4 form-group mt-3">
                                    <label for="edit_estado_financiero">Financiero</label>
                                    <select class="form-select" name="estado_financiero" id="edit_estado_financiero">
                                        <option value="REGULAR">REGULAR</option>
                                        <option value="DEUDOR">DEUDOR</option>
                                    </select>
                                </div>

                                <div class="col-md-4 form-group mt-3">
                                    <label for="edit_estado_disciplinario">Disciplinario</label>
                                    <select class="form-select" name="estado_disciplinario"
                                        id="edit_estado_disciplinario">
                                        <option value="SIN_SANCION">SIN SANCIÓN</option>
                                        <option value="SANCIONADO">SANCIONADO</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="edit_foto">Foto</label>
                                <input type="file" class="dropify" name="foto" id="edit_foto" accept="image/*"
                                    data-height="150">
                            </div>

                            <div class="form-group mt-4 text-end">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modal_ver_estudiante" tabindex="-1" aria-labelledby="modalVerEstudianteLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="max-width: 800px;">
                <div class="modal-content border-0 shadow rounded-3">
                    <div class="modal-header bg-primary text-white py-2 px-3">
                        <h6 class="modal-title fw-bold mb-0" id="modalVerEstudianteLabel">Información del Estudiante</h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body px-3 py-2">
                        <div class="row g-2">
                            <!-- Izquierda -->
                            <div class="col-4 d-flex flex-column align-items-center text-center">
                                <img id="ver_foto" class="img-fluid rounded-circle border shadow-sm mb-2" alt="Foto"
                                    width="90" height="90" style="object-fit: cover;">
                                <div id="ver_nombre_completo" class="fw-semibold small"></div>
                                <div id="ver_tipo_alumno" class="text-muted small"></div>
                                <span id="ver_estado" class="badge bg-success small mt-1 px-2 py-1"></span>
                            </div>

                            <!-- Derecha -->
                            <div class="col-8">
                                <div class="row g-2 small">
                                    <div class="col-12 border-bottom pb-1 mb-2 fw-semibold text-primary">Datos del
                                        Estudiante</div>

                                    <div class="col-6">
                                        <label class="fw-semibold mb-0">Documento:</label>
                                        <div id="ver_documento" class="text-muted"></div>
                                    </div>

                                    <div class="col-6 d-none" id="grupo_ver_codigo">
                                        <label class="fw-semibold mb-0">Código Estudiante:</label>
                                        <div id="ver_codigo_estudiante" class="text-muted"></div>
                                    </div>

                                    <div class="col-6 d-none" id="grupo_ver_carrera">
                                        <label class="fw-semibold mb-0">Carrera:</label>
                                        <div id="ver_carrera" class="text-muted"></div>
                                    </div>

                                    <div class="col-6">
                                        <label class="fw-semibold mb-0">Estado Financiero:</label>
                                        <div id="ver_estado_financiero" class="text-muted"></div>
                                    </div>

                                    <div class="col-6">
                                        <label class="fw-semibold mb-0">Estado Disciplinario:</label>
                                        <div id="ver_estado_disciplinario" class="text-muted"></div>
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

                <h4 class="card-title">Estudiantes</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_nuevo_estudiante">Registrar</button>


                <br><br>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="tablaEstudiantes" class="table table-sm w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Foto</th>
                                        <th>Documento</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
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
            let table = $('#tablaEstudiantes').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('estudiantes.listar') }}",
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
                        data: 'nombres'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `${row.apellido_paterno} ${row.apellido_materno}`;
                        }
                    },
                    {
                        data: 'estado',
                        render: function(estado) {
                            let badge = estado === 'ACTIVO' ? 'success' : 'secondary';
                            return `<span class="badge bg-${badge}">${estado}</span>`;
                        }
                    },
                    {
                        data: 'id_estudiante',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let foto = row.foto ? `/storage/${row.foto}` :
                                '/images/default-avatar.png';
                            let nombreCompleto =
                                `${row.nombres} ${row.apellido_paterno} ${row.apellido_materno}`;

                            return `
                                <button type="button" class="btn btn-info shadow btn-xs sharp me-1 btn-ver"
                                    title="Ver"
                                    data-id="${row.id_estudiante}"
                                    data-id_persona="${row.id_persona}"
                                    data-documento="${row.documento}"
                                    data-nombres="${row.nombres}"
                                    data-apellido_paterno="${row.apellido_paterno}"
                                    data-apellido_materno="${row.apellido_materno}"
                                    data-id_tipo_alumno="${row.id_tipo_alumno}"
                                    data-tipo_alumno="${row.tipo_alumno ?? ''}"
                                    data-id_carrera="${row.id_carrera ?? ''}"
                                    data-carrera="${row.carrera ?? ''}"
                                    data-codigo_estudiante="${row.codigo_estudiante ?? ''}"
                                    data-estado="${row.estado}"
                                    data-estado_financiero="${row.estado_financiero}"
                                    data-estado_disciplinario="${row.estado_disciplinario}"
                                    data-foto="${foto}">
                                    <i class="mdi mdi-eye"></i>
                                </button>

                                <button type="button" class="btn btn-primary shadow btn-xs sharp me-1 btn-editar"
                                    title="Editar"
                                    data-id="${row.id_estudiante}"
                                    data-id_persona="${row.id_persona}"
                                    data-documento="${row.documento}"
                                    data-nombres="${row.nombres}"
                                    data-apellido_paterno="${row.apellido_paterno}"
                                    data-apellido_materno="${row.apellido_materno}"
                                    data-id_tipo_alumno="${row.id_tipo_alumno}"
                                    data-id_carrera="${row.id_carrera ?? ''}"
                                    data-codigo_estudiante="${row.codigo_estudiante ?? ''}"
                                    data-estado="${row.estado}"
                                    data-estado_financiero="${row.estado_financiero}"
                                    data-estado_disciplinario="${row.estado_disciplinario}"
                                    data-foto="${foto}">
                                    <i class="mdi mdi-pencil"></i>
                                </button>

                                <form method="POST" action="/estudiantes/${row.id_estudiante}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger shadow btn-xs sharp me-1"
                                        onclick="return confirm('¿Eliminar este estudiante?')">
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
                    No hay estudiantes registrados
                </div>`,
                    info: "_START_ - _END_ de _TOTAL_",
                    infoEmpty: "0 a 0 de 0",
                    infoFiltered: "(filtrado de _MAX_ registros totales)"
                },
                dom: '<"d-flex justify-content-between align-items-center"<"left-section"l><"right-section"f>>rtip'
            });

            console.log("✅ Tabla de estudiantes inicializada");
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
            $('#modal_nuevo_estudiante').on('hidden.bs.modal', function() {
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
        document.addEventListener('DOMContentLoaded', function() {
            const tipoAlumnoSelect = document.getElementById('id_tipo_alumno');
            const grupoCarrera = document.getElementById('grupo_carrera');
            const grupoCodigo = document.getElementById('grupo_codigo');
            const btnRegistrar = document.getElementById('btn_registrar_estudiante');
            const inputCodigo = document.getElementById('codigo_estudiante');
            const selectCarrera = document.getElementById('id_carrera');

            tipoAlumnoSelect.addEventListener('change', function() {
                const selectedText = tipoAlumnoSelect.options[tipoAlumnoSelect.selectedIndex].text.trim();
                if (selectedText === 'Particular') {
                    grupoCarrera.classList.add('d-none');
                    grupoCodigo.classList.add('d-none');
                    inputCodigo.removeAttribute('required');
                    selectCarrera.removeAttribute('required');
                } else {
                    grupoCarrera.classList.remove('d-none');
                    grupoCodigo.classList.remove('d-none');
                    inputCodigo.setAttribute('required', 'required');
                    selectCarrera.setAttribute('required', 'required');
                }
            });

            // Habilita el botón al seleccionar persona
            document.getElementById('id_persona').addEventListener('change', function() {
                btnRegistrar.disabled = !this.value;
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tipoAlumnoSelectEdit = document.getElementById('edit_id_tipo_alumno');
            const grupoCarreraEdit = document.getElementById('edit_grupo_carrera');
            const grupoCodigoEdit = document.getElementById('edit_grupo_codigo');
            const inputCodigoEdit = document.getElementById('edit_codigo_estudiante');
            const selectCarreraEdit = document.getElementById('edit_id_carrera');

            function toggleCamposEdit() {
                const selectedText = tipoAlumnoSelectEdit.options[tipoAlumnoSelectEdit.selectedIndex]?.text.trim();
                if (selectedText === 'Particular') {
                    grupoCarreraEdit.classList.add('d-none');
                    grupoCodigoEdit.classList.add('d-none');
                    inputCodigoEdit.removeAttribute('required');
                    selectCarreraEdit.removeAttribute('required');
                } else {
                    grupoCarreraEdit.classList.remove('d-none');
                    grupoCodigoEdit.classList.remove('d-none');
                    inputCodigoEdit.setAttribute('required', 'required');
                    selectCarreraEdit.setAttribute('required', 'required');
                }
            }

            // Evento al cambiar tipo de alumno en modo edición
            tipoAlumnoSelectEdit.addEventListener('change', toggleCamposEdit);

            // Llama también esta función al abrir el modal para mantener el estado correcto
            window.mostrarCamposSegunTipoAlumnoEdit = toggleCamposEdit;
        });
    </script>

    <script>
        $('#tablaEstudiantes').on('click', '.btn-editar', function() {
            let btn = $(this);

            // Rellenar campos
            $('#edit_id_estudiante').val(btn.data('id'));
            $('#edit_id_persona').val(btn.data('id_persona'));
            $('#edit_documento').val(btn.data('documento'));
            $('#edit_nombres').val(btn.data('nombres'));
            $('#edit_apellidos').val(`${btn.data('apellido_paterno')} ${btn.data('apellido_materno')}`);
            $('#edit_id_tipo_alumno').val(btn.data('id_tipo_alumno')).trigger('change');
            $('#edit_estado').val(btn.data('estado'));
            $('#edit_estado_financiero').val(btn.data('estado_financiero'));
            $('#edit_estado_disciplinario').val(btn.data('estado_disciplinario'));

            let carrera = btn.data('id_carrera');
            if (carrera) {
                $('#edit_grupo_carrera').removeClass('d-none');
                $('#edit_id_carrera').val(carrera);
            } else {
                $('#edit_grupo_carrera').addClass('d-none');
                $('#edit_id_carrera').val('');
            }

            let codigo = btn.data('codigo_estudiante');
            if (codigo) {
                $('#edit_grupo_codigo').removeClass('d-none');
                $('#edit_codigo_estudiante').val(codigo);
            } else {
                $('#edit_grupo_codigo').addClass('d-none');
                $('#edit_codigo_estudiante').val('');
            }

            // Cargar foto con Dropify
            let foto = btn.data('foto');
            const dropify = $('#edit_foto').data('dropify');
            if (dropify) {
                dropify.resetPreview();
                dropify.clearElement();
                if (foto) {
                    dropify.settings.defaultFile = foto;
                    dropify.destroy();
                    dropify.init();
                }
            }

            // Setear action del formulario
            $('#formEditarEstudiante').attr('action', `/estudiantes/${btn.data('id')}`);

            $('#modal_editar_estudiante').modal('show');
        });
    </script>

    <script>
        $(document).on('click', '.btn-ver', function() {
            const btn = $(this);

            // Cargar datos del botón
            const nombreCompleto =
                `${btn.data('nombres')} ${btn.data('apellido_paterno')} ${btn.data('apellido_materno')}`;
            const tipoAlumno = btn.data('tipo_alumno');
            const estado = btn.data('estado');
            const documento = btn.data('documento');
            const codigo = btn.data('codigo_estudiante') || '';
            const carrera = btn.data('carrera') || '';
            const estadoFinanciero = btn.data('estado_financiero');
            const estadoDisciplinario = btn.data('estado_disciplinario');
            const foto = btn.data('foto');

            $('#ver_foto').attr('src', foto);
            $('#ver_nombre_completo').text(nombreCompleto);
            $('#ver_tipo_alumno').text(tipoAlumno);
            $('#ver_estado').text(estado).removeClass().addClass(
                `badge rounded-pill bg-${estado === 'ACTIVO' ? 'success' : 'secondary'}`);
            $('#ver_documento').text(documento);
            $('#ver_codigo_estudiante').text(codigo);
            $('#ver_carrera').text(carrera);
            $('#ver_estado_financiero').text(estadoFinanciero);
            $('#ver_estado_disciplinario').text(estadoDisciplinario);

            // Mostrar u ocultar campos según tipo de alumno
            if (tipoAlumno === 'Particular') {
                $('#grupo_ver_codigo, #grupo_ver_carrera').addClass('d-none');
            } else {
                $('#grupo_ver_codigo, #grupo_ver_carrera').removeClass('d-none');
            }

            $('#modal_ver_estudiante').modal('show');
        });
    </script>

@endsection
