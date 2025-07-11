@extends('recursos.barra')
@section('title', 'Contratos Docentes | Ceinfo')
@section('contratos_docentes')

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
                                    href="{{ route('contratos_docentes') }}" role="tab" aria-controls="overview"
                                    aria-selected="true">Contratos</a>
                            </li>

                        </ul>

                    </div>

                </div>
            </div>
        </div>
        <br>

        <div class="modal fade" id="modal_nuevo_contrato" tabindex="-1" aria-labelledby="modalContratoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title"><b>Asignar Contrato a Docente</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="{{ route('contratos_docentes.store') }}">
                            @csrf

                            <!-- Buscar Docente -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group position-relative">
                                        <label for="search">Buscar Docente</label>
                                        <div class="input-group align-items-center">
                                            <input type="text" class="form-control" id="search" name="search"
                                                placeholder="Ingrese DNI, nombre o apellido" minlength="4"
                                                autocomplete="off">
                                            <button type="button" class="clear-search d-none" id="clear-search"
                                                title="Limpiar búsqueda">&times;</button>
                                        </div>
                                        <input type="hidden" id="id_docente" name="id_docente">
                                        <div id="search-results" class="list-group" style="font-size: 0.875rem;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="id_horario">Horario asignado</label>
                                <select class="form-select form-select-sm" name="id_horario" id="id_horario" required>
                                    <option value="">Seleccione un horario</option>
                                    @foreach ($horarios as $horario)
                                        <option value="{{ $horario->id_horario }}">
                                            {{ $horario->curso->nombre_curso }}
                                            | {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                                            | {{ $horario->modalidad }}
                                            | {{ $horario->duracion_meses }}
                                            {{ $horario->duracion_meses == 1 ? 'mes' : 'meses' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                            <!-- Fechas -->
                            <div class="row mt-3">
                                <div class="col-md-6 form-group">
                                    <label for="fecha_inicio">Fecha de Inicio</label>
                                    <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio"
                                        required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="fecha_fin">Fecha de Fin</label>
                                    <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" required>
                                </div>
                            </div>

                            <!-- Tipo de contrato y estado -->
                            <div class="row mt-3">
                                <div class="col-md-12 form-group">
                                    <label for="tipo_contrato">Tipo de Contrato</label>
                                    <input type="text" class="form-control" name="tipo_contrato" id="tipo_contrato"
                                        required placeholder="Honorarios, CAS, Nombrado...">
                                </div>

                                
                            </div>

                            <!-- Observación -->
                            <div class="form-group mt-3">
                                <label for="observacion">Observación</label>
                                <textarea class="form-control" name="observacion" id="observacion" rows="2" placeholder="Opcional"></textarea>
                            </div>

                            <!-- Botones -->
                            <div class="form-group mt-4 text-end">
                                <button type="submit" class="btn btn-primary" id="btn_asignar_contrato">
                                    Asignar Contrato
                                </button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


        <div class="modal fade" id="modal_editar_contrato" tabindex="-1" aria-labelledby="modalEditarContratoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title"><b>Editar Contrato de Docente</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <form id="form_editar_contrato" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- ID oculto -->
                            <input type="hidden" name="id_contrato" id="editar_id_contrato">

                            <!-- Docente (solo visual, no editable) -->
                            <div class="form-group">
                                <label for="editar_docente">Docente</label>
                                <input type="text" class="form-control" id="editar_docente" disabled>
                            </div>

                            <!-- Horario -->
                            <div class="form-group mt-3">
                                <label for="editar_horario_texto">Horario asignado</label>
                                <input type="text" class="form-control form-control-sm" id="editar_horario_texto"
                                    name="horario_texto" disabled>
                                <input type="hidden" id="editar_id_horario" name="id_horario">
                                <!-- oculto para enviar el id -->
                            </div>


                            <!-- Fechas -->
                            <div class="row mt-3">
                                <div class="col-md-6 form-group">
                                    <label for="editar_fecha_inicio">Fecha de Inicio</label>
                                    <input type="date" class="form-control" name="fecha_inicio"
                                        id="editar_fecha_inicio" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="editar_fecha_fin">Fecha de Fin</label>
                                    <input type="date" class="form-control" name="fecha_fin" id="editar_fecha_fin"
                                        required>
                                </div>
                            </div>

                            <!-- Tipo y estado -->
                            <div class="row mt-3">
                                <div class="col-md-6 form-group">
                                    <label for="editar_tipo_contrato">Tipo de Contrato</label>
                                    <input type="text" class="form-control" name="tipo_contrato"
                                        id="editar_tipo_contrato" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="editar_estado">Estado</label>
                                    <select class="form-select" name="estado" id="editar_estado" required>
                                        <option value="VIGENTE">VIGENTE</option>
                                        <option value="FINALIZADO">FINALIZADO</option>
                                        <option value="ANULADO">ANULADO</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Observación -->
                            <div class="form-group mt-3">
                                <label for="editar_observacion">Observación</label>
                                <textarea class="form-control" name="observacion" id="editar_observacion" rows="2"></textarea>
                            </div>

                            <!-- Botones -->
                            <div class="form-group mt-4 text-end">
                                <button type="submit" class="btn btn-primary">Actualizar Contrato</button>
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

                <h4 class="card-title">Contratos docentes</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_nuevo_contrato">Registrar</button>


                <br><br>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="tablaContratos" class="table table-sm w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Docente</th>
                                        <th>Horario</th>
                                        <th>Tipo de Contrato</th>
                                        <th>Fechas</th>
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
            let table = $('#tablaContratos').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('contratos_docentes.listar') }}",
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
                        data: 'nombre_docente',
                        render: function(data) {
                            return data || '-';
                        }
                    },

                    {
                        data: null,
                        render: function(data) {
                            return `${data.nombre_curso} <br><small>${data.hora_inicio} - ${data.hora_fin}</small>`;
                        }
                    },
                    {
                        data: 'tipo_contrato'
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `
                                <div class="text-center" style="font-size: 0.8rem; line-height: 1.2;">
                                    <div>${data.fecha_inicio}</div>
                                    <small class="text-muted">al</small>
                                    <div>${data.fecha_fin}</div>
                                </div>
                            `;
                        }
                    },


                    {
                        data: 'estado',
                        render: function(estado) {
                            let colores = {
                                'VIGENTE': 'success',
                                'FINALIZADO': 'secondary',
                                'ANULADO': 'danger'
                            };
                            let clase = colores[estado] || 'secondary';
                            return `<span class="badge bg-${clase}">${estado}</span>`;
                        }
                    },
                    {
                        data: 'id_contrato',
                        orderable: false,
                        searchable: false,
                        render: function(id, type, row) {
                            const curso = row.nombre_curso || '---';
                            const horaInicio = row.hora_inicio?.substring(0, 5) || '--:--';
                            const horaFin = row.hora_fin?.substring(0, 5) || '--:--';
                            const horarioTexto = `${curso} | ${horaInicio} - ${horaFin}`;
                            return `
                                <button type="button" class="btn btn-primary btn-xs sharp me-1 btn-editar-contrato"
                                    data-id="${id}"
                                    data-docente="${row.nombre_docente || ''}"
                                    data-id_horario="${row.id_horario}"
                                    data-horario="${horarioTexto}"
                                    data-fecha_inicio="${row.fecha_inicio}"
                                    data-fecha_fin="${row.fecha_fin}"
                                    data-tipo_contrato="${row.tipo_contrato}"
                                    data-estado="${row.estado}"
                                    data-observacion="${row.observacion || ''}"
                                    title="Editar">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                <form method="POST" action="/contratos-docentes/${id}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs sharp"
                                        onclick="return confirm('¿Eliminar este contrato?')">
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
                        No hay contratos registrados
                    </div>`,
                    info: "_START_ - _END_ de _TOTAL_",
                    infoEmpty: "0 a 0 de 0",
                    infoFiltered: "(filtrado de _MAX_ registros totales)"
                },
                dom: '<"d-flex justify-content-between align-items-center"<"left-section"l><"right-section"f>>rtip'
            });

            console.log("✅ Tabla de contratos inicializada");
        });
    </script>
    <script>
        $(document).ready(function() {
            // Buscar docente cuando se escribe en el input
            $('#search').on('keyup', function() {
                let query = $(this).val().trim();

                if (query.length >= 4) {
                    $.ajax({
                        url: "{{ route('docentes.buscar') }}",
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
                                        data-id="${item.id_docente}"
                                        data-documento="${item.documento}"
                                        data-correo="${item.correo || ''}">
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
                                '<p class="text-danger p-2">Error en la búsqueda</p>'
                            );
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    $('#search-results').html('');
                }
            });

            // Seleccionar docente del resultado
            $(document).on('click', '.result-item', function(e) {
                e.preventDefault();

                $('#search').val($(this).text());
                $('#id_docente').val($(this).data('id')); // Cambiado a id_docente
                $('#email').val($(this).data('correo') || '');
                $('#search-results').html('');
                $('#search').prop('disabled', true);
                $('#clear-search').removeClass('d-none');
                validarFormulario?.();
            });

            // Botón de limpiar búsqueda
            $('#clear-search').on('click', function() {
                $('#search').val('').prop('disabled', false).focus();
                $('#id_docente').val('');
                $('#search-results').html('');
                $('#clear-search').addClass('d-none');
            });

            // Al cerrar modal
            $('#modal_nuevo_contrato').on('hidden.bs.modal', function() {
                const form = $(this).find('form')[0];
                form.reset();

                $('#search').prop('disabled', false).val('');
                $('#search-results').html('');
                $('#id_docente').val('');
                $('#clear-search').addClass('d-none');

                const dropify = $('#foto').data('dropify');
                if (dropify) dropify.resetPreview().clearElement();
            });
        });
    </script>

    <script>
        $(document).on('click', '.btn-editar-contrato', function() {
            const btn = $(this);

            $('#editar_id_contrato').val(btn.data('id'));
            $('#editar_docente').val(btn.data('docente'));
            $('#editar_id_horario').val(btn.data('id_horario'));
            $('#editar_horario_texto').val(btn.data('horario'));
            $('#editar_fecha_inicio').val(btn.data('fecha_inicio'));
            $('#editar_fecha_fin').val(btn.data('fecha_fin'));
            $('#editar_tipo_contrato').val(btn.data('tipo_contrato'));
            $('#editar_estado').val(btn.data('estado'));
            $('#editar_observacion').val(btn.data('observacion'));

            const action = `/contratos-docentes/${btn.data('id')}`;
            $('#form_editar_contrato').attr('action', action);

            $('#modal_editar_contrato').modal('show');
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
