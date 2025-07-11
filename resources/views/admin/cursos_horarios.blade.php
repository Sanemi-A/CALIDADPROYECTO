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

                                    <!-- Fecha inicio / Fecha fin / Aula -->
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fecha_inicio">Fecha de inicio</label>
                                                <input type="date" name="fecha_inicio" id="fecha_inicio"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fecha_fin">Fecha de fin</label>
                                                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="aula">Aula o salón</label>
                                                <input type="text" name="aula" id="aula" class="form-control"
                                                    maxlength="100">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hora inicio / Hora fin / Duración -->
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="hora_inicio">Hora de inicio</label>
                                                <input type="time" name="hora_inicio" id="hora_inicio"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="hora_fin">Hora de fin</label>
                                                <input type="time" name="hora_fin" id="hora_fin"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="duracion_meses">Duración (meses)</label>
                                                <input type="number" name="duracion_meses" id="duracion_meses"
                                                    class="form-control" min="1" max="24" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modalidad / Precio / Estado -->
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="modalidad">Modalidad</label>
                                                <select name="modalidad" id="modalidad" class="form-select" required>
                                                    <option value="PRESENCIAL">PRESENCIAL</option>
                                                    <option value="VIRTUAL">VIRTUAL</option>
                                                    <option value="HÍBRIDO">HÍBRIDO</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="precio_mensual">Precio mensual (S/)</label>
                                                <input type="number" step="0.01" min="0"
                                                    name="precio_mensual" id="precio_mensual" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="estado">Estado</label>
                                                <select name="estado" id="estado" class="form-select" required>
                                                    <option value="ACTIVO" selected>ACTIVO</option>

                                                    <option value="ESPERA">ESPERA</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botones -->
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
        <div class="modal fade" id="modalEditarDias" tabindex="-1" aria-labelledby="editarDiasLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 550px;">
                <form id="formEditarDias" method="POST" action="{{ route('curso_horarios.actualizar_dias') }}">
                    @csrf
                    <input type="hidden" name="id_horario" id="modal_id_horario">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Seleccionar días de clase</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body p-3">
                            <div class="container-fluid">
                                <div class="row g-2">
                                    @foreach (['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'] as $dia)
                                        <div class="col-6">
                                            <div
                                                class="form-check form-switch d-flex align-items-center justify-content-between w-100">
                                                <label class="form-check-label text-capitalize me-2"
                                                    for="switch_{{ $dia }}">{{ $dia }}</label>
                                                <input class="form-check-input ms-auto" type="checkbox"
                                                    id="switch_{{ $dia }}" name="{{ $dia }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>




        <div class="modal fade" id="modal_editarhorario" tabindex="-1" role="dialog"
            aria-labelledby="modalLabelEditarHorario" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Editar Horario</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="formEditarHorario">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id_horario" id="edit_id_horario">

                                    <!-- Curso (Solo texto, no se edita) -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Curso</label>
                                                <input type="text" id="edit_nombre_curso" class="form-control"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fechas y Aula -->
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit_fecha_inicio">Fecha de inicio</label>
                                                <input type="date" name="fecha_inicio" id="edit_fecha_inicio"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit_fecha_fin">Fecha de fin</label>
                                                <input type="date" name="fecha_fin" id="edit_fecha_fin"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit_aula">Aula o salón</label>
                                                <input type="text" name="aula" id="edit_aula" class="form-control"
                                                    maxlength="100">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Horas y duración -->
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit_hora_inicio">Hora de inicio</label>
                                                <input type="time" name="hora_inicio" id="edit_hora_inicio"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit_hora_fin">Hora de fin</label>
                                                <input type="time" name="hora_fin" id="edit_hora_fin"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit_duracion_meses">Duración (meses)</label>
                                                <input type="number" name="duracion_meses" id="edit_duracion_meses"
                                                    class="form-control" min="1" max="24" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modalidad, Precio, Estado -->
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit_modalidad">Modalidad</label>
                                                <select name="modalidad" id="edit_modalidad" class="form-select"
                                                    required>
                                                    <option value="PRESENCIAL">PRESENCIAL</option>
                                                    <option value="VIRTUAL">VIRTUAL</option>
                                                    <option value="HÍBRIDO">HÍBRIDO</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit_precio_mensual">Precio mensual (S/)</label>
                                                <input type="number" step="0.01" min="0"
                                                    name="precio_mensual" id="edit_precio_mensual" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit_estado">Estado</label>
                                                <select name="estado" id="edit_estado" class="form-select" required>
                                                    <option value="ACTIVO">ACTIVO</option>
                                                    <option value="INACTIVO">INACTIVO</option>
                                                    <option value="ESPERA">ESPERA</option>
                                                    <option value="FINALIZADO">FINALIZADO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botones -->
                                    <div class="row mt-4">
                                        <div class="col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary me-2">Actualizar</button>
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                    </div>
                                </form>
                            </div> <!-- /.card-body -->
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
                                        <th>Precio</th>
                                        <th class="text-center">Días</th>


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
                        data: null,
                        render: function(data, type, row) {
                            let nivel = row.nivel ? row.nivel.toUpperCase() : 'SIN NIVEL';

                            let nivelColor = {
                                'BÁSICO': 'badge badge-opacity-primary',
                                'INTERMEDIO': 'badge badge-opacity-warning',
                                'AVANZADO': 'badge badge-opacity-success'
                            };

                            let claseNivel = nivelColor[nivel] || 'badge badge-opacity-secondary';

                            return `
                                <div class="position-relative" style="padding-top: 1.2rem;">
                                    <span class="${claseNivel}" style="
                                        position: absolute;
                                        top: 0;
                                        left: 0.1rem;
                                        font-size: 0.6rem;
                                        padding: 0.2em 0.4em;
                                        line-height: 1;
                                        z-index: 1;
                                    ">${nivel}</span>
                                    <p class="mb-0 fw-semibold" style="font-size: 0.875rem;">${row.nombre_curso}</p>
                                </div>
                            `;
                        }
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
                            let inicio = data.hora_inicio?.slice(0, 5); // solo HH:mm
                            let fin = data.hora_fin?.slice(0, 5);

                            // Convertir hora_inicio a entero para clasificar
                            let horaInt = parseInt(data.hora_inicio?.split(':')[0]);
                            let periodo = 'SIN HORA';
                            let badgeClass = 'badge badge-opacity-secondary';

                            if (!isNaN(horaInt)) {
                                if (horaInt < 12) {
                                    periodo = 'MAÑANA';
                                    badgeClass = 'badge badge-opacity-info';
                                } else if (horaInt < 18) {
                                    periodo = 'TARDE';
                                    badgeClass = 'badge badge-opacity-warning';
                                } else {
                                    periodo = 'NOCHE';
                                    badgeClass = 'badge badge-opacity-dark';
                                }
                            }

                            return `
                                <div class="position-relative" style="padding-top: 1.2rem;">
                                    <span class="${badgeClass}" style="
                                        position: absolute;
                                        top: 0;
                                        left: 0.1rem;
                                        font-size: 0.6rem;
                                        padding: 0.2em 0.4em;
                                        line-height: 1;
                                        z-index: 1;
                                    ">${periodo}</span>
                                    <p class="mb-0 fw-semibold" style="font-size: 0.875rem;">${inicio} - ${fin}</p>
                                </div>
                            `;
                        }
                    },

                    {
                        data: null,
                        render: function(row) {
                            let modalidad = row.modalidad ?? 'SIN MODALIDAD';
                            let meses = row.duracion_meses;
                            let duracionTexto = `${meses} mes${meses > 1 ? 'es' : ''}`;

                            let modalidadColor = {
                                'PRESENCIAL': 'badge badge-opacity-success',
                                'VIRTUAL': 'badge badge-opacity-primary',
                                'HÍBRIDO': 'badge badge-opacity-warning'
                            };

                            let claseBadge = modalidadColor[modalidad.toUpperCase()] ||
                                'badge badge-opacity-secondary';

                            return `
                                <div class="position-relative" style="padding-top: 1.2rem;">
                                    <span class="${claseBadge}" style="
                                        position: absolute;
                                        top: 0;
                                        left: 0.1rem;
                                        font-size: 0.6rem;
                                        padding: 0.2em 0.4em;
                                        line-height: 1;
                                        z-index: 1;
                                    ">${modalidad.toUpperCase()}</span>
                                    <p class="mb-0 fw-semibold" style="font-size: 0.875rem;">${duracionTexto}</p>
                                </div>
                            `;
                        }
                    },

                    {
                        data: 'precio_mensual',
                        render: function(precio) {
                            return `S/ ${parseFloat(precio).toFixed(2)}`;
                        }
                    },
                    {
                        data: 'dias',
                        render: function(dias, type, row) {
                            let colores = {
                                'Lun': 'badge-opacity-info',
                                'Mar': 'badge-opacity-info',
                                'Mié': 'badge-opacity-info',
                                'Jue': 'badge-opacity-info',
                                'Vie': 'badge-opacity-info',
                                'Sáb': 'badge-opacity-primary',
                                'Dom': 'badge-opacity-primary',
                            };

                            let badges = dias
                                .split(', ')
                                .map(d => `
                                    <span class="badge ${colores[d] || 'badge-opacity-secondary'} me-1 mb-1" style="
                                        font-size: 0.6rem;
                                        padding: 0.2em 0.4em;
                                        line-height: 1;
                                    ">${d}</span>
                                `).join('');

                            return `
                                <div class="d-flex flex-column align-items-center" style="min-height: 3.5rem;">
                                    <div class="mb-1 text-center">
                                        ${badges}
                                    </div>
                                    <button class="btn btn-light btn-xs border btn-editar-dias"
                                        style="font-size: 0.75rem; padding: 0.25rem 0.5rem;"
                                        title="Editar días"
                                        data-id="${row.id_horario}"
                                        data-lunes="${row.lunes}"
                                        data-martes="${row.martes}"
                                        data-miercoles="${row.miercoles}"
                                        data-jueves="${row.jueves}"
                                        data-viernes="${row.viernes}"
                                        data-sabado="${row.sabado}"
                                        data-domingo="${row.domingo}">
                                        <i class="mdi mdi-calendar-edit"></i>
                                    </button>
                                </div>
                            `;
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
                            <button class="btn btn-primary shadow btn-xs sharp me-1 btn-editar-horario"
                                data-id="${row.id_horario}"
                                data-curso="${row.nombre_curso}"
                                data-fecha_inicio="${row.fecha_inicio || ''}"
                                data-fecha_fin="${row.fecha_fin || ''}"
                                data-aula="${row.aula || ''}"
                                data-hora_inicio="${row.hora_inicio}"
                                data-hora_fin="${row.hora_fin}"
                                data-duracion="${row.duracion_meses}"
                                data-modalidad="${row.modalidad}"
                                data-precio="${row.precio_mensual}"
                                data-estado="${row.estado}"
                                title="Editar">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            <form method="POST" action="/curso-horarios/${id}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger shadow btn-xs sharp me-1"
                                    onclick="return confirm('¿Eliminar este horario?')" title="Eliminar">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </form>`;
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
        $(document).on('click', '.btn-editar-dias', function() {
            const id = $(this).data('id');
            $('#modal_id_horario').val(id);

            // Resetear switches
            ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'].forEach(dia => {
                const checked = $(this).data(dia) == 1;
                $(`#switch_${dia}`).prop('checked', checked);
            });

            $('#modalEditarDias').modal('show');
        });
    </script>
    <script>
        $(document).on('click', '.btn-editar-horario', function() {
            const button = $(this);
            const id = button.data('id');

            // Asegurar valores seguros con fallback en caso de undefined
            $('#edit_id_horario').val(id);
            $('#edit_nombre_curso').val(button.data('curso') || '');
            $('#edit_fecha_inicio').val(button.data('fecha_inicio') || '');
            $('#edit_fecha_fin').val(button.data('fecha_fin') || '');
            $('#edit_aula').val(button.data('aula') || '');
            $('#edit_hora_inicio').val(button.data('hora_inicio') || '');
            $('#edit_hora_fin').val(button.data('hora_fin') || '');
            $('#edit_duracion_meses').val(button.data('duracion') || '');
            $('#edit_modalidad').val(button.data('modalidad') || 'PRESENCIAL');
            $('#edit_precio_mensual').val(button.data('precio') || '');
            $('#edit_estado').val(button.data('estado') || 'ACTIVO');

            // Actualizar la URL de acción del formulario
            $('#formEditarHorario').attr('action', `/curso-horarios/${id}`);

            // Mostrar el modal
            $('#modal_editarhorario').modal('show');
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
