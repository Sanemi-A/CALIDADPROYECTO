@extends('recursos.barra')
@section('title', 'Datos personales | Cinfo')
@section('personas')

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
                                <a class="nav-link  ps-0" id="home-tab" href="">Sistema</a>
                            </li>
                            <li class="nav-item mx-2">
                                <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab"
                                    href="{{ route('usuarios') }}" role="tab" aria-controls="overview"
                                    aria-selected="true">personas</a>
                            </li>

                        </ul>

                    </div>

                </div>
            </div>
        </div>
        <br>

        <div class="modal fade" id="modal_nuevapersona" tabindex="-1" role="dialog" aria-labelledby="modalLabelPersona"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabelPersona"><b>Nuevo Registro</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('personas.store') }}" class="forms-sample">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tipo_documento">Tipo Documento</label>
                                                <select class="form-select" id="tipo_documento" name="tipo_documento"
                                                    required>
                                                    <option value="DNI" selected>DNI</option>
                                                    <option value="RUC">RUC</option>
                                                    <option value="LM">Libreta Militar</option>
                                                    <option value="CE">Carnet Extranjería</option>
                                                    <option value="PAS">Pasaporte</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="documento">Número de Documento</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="documento"
                                                        name="documento" placeholder="Documento" required>
                                                    <button class="btn btn-primary" type="button" id="buscarDocumento"
                                                        title="Buscar por documento">
                                                        <i class="mdi mdi-magnify"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nombres">Nombres</label>
                                                <input type="text" class="form-control" id="nombres" name="nombres"
                                                    placeholder="Nombres" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="apellido_paterno">Apellido Paterno</label>
                                                <input type="text" class="form-control" id="apellido_paterno"
                                                    name="apellido_paterno" placeholder="Apellido Paterno" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="apellido_materno">Apellido Materno</label>
                                                <input type="text" class="form-control" id="apellido_materno"
                                                    name="apellido_materno" placeholder="Apellido Materno" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="genero">Género</label>
                                                <select class="form-select" id="genero" name="genero" required>
                                                    <option value="" disabled selected>Seleccione</option>
                                                    <option value="M">Masculino</option>
                                                    <option value="F">Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="edad">Edad</label>
                                                <input type="number" class="form-control" id="edad" name="edad"
                                                    min="1" max="120" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="celular">Celular</label>
                                                <input type="text" class="form-control" id="celular" name="celular"
                                                    placeholder="Celular">
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="correo">Correo</label>
                                                <input type="email" class="form-control" id="correo" name="correo"
                                                    placeholder="Correo electrónico">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="direccion">Dirección</label>
                                                <input type="text" class="form-control" id="direccion"
                                                    name="direccion" placeholder="Dirección">
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



        <div class="modal fade" id="modal_editarpersona" tabindex="-1" role="dialog"
            aria-labelledby="modalLabelEditarPersona" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabelEditarPersona"><b>Editar</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="formEditarPersona" class="forms-sample">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" id="editar_id_persona" name="id">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editar_tipo_documento">Tipo Documento</label>
                                                <select class="form-select" id="editar_tipo_documento"
                                                    name="tipo_documento" required>
                                                    <option value="DNI">DNI</option>
                                                    <option value="RUC">RUC</option>
                                                    <option value="LM">Libreta Militar</option>
                                                    <option value="CE">Carnet Extranjería</option>
                                                    <option value="PAS">Pasaporte</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editar_documento">Número de Documento</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="editar_documento"
                                                        name="documento" placeholder="Documento" required>
                                                    <button class="btn btn-primary" type="button"
                                                        id="buscarEditarDocumento" title="Buscar por documento">
                                                        <i class="mdi mdi-magnify"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editar_nombres">Nombres</label>
                                                <input type="text" class="form-control" id="editar_nombres"
                                                    name="nombres" placeholder="Nombres" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editar_apellido_paterno">Apellido Paterno</label>
                                                <input type="text" class="form-control" id="editar_apellido_paterno"
                                                    name="apellido_paterno" placeholder="Apellido Paterno" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editar_apellido_materno">Apellido Materno</label>
                                                <input type="text" class="form-control" id="editar_apellido_materno"
                                                    name="apellido_materno" placeholder="Apellido Materno" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editar_genero">Género</label>
                                                <select class="form-select" id="editar_genero" name="genero" required>
                                                    <option value="" disabled selected>Seleccione</option>
                                                    <option value="M">Masculino</option>
                                                    <option value="F">Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editar_edad">Edad</label>
                                                <input type="number" class="form-control" id="editar_edad"
                                                    name="edad" min="1" max="120" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editar_celular">Celular</label>
                                                <input type="text" class="form-control" id="editar_celular"
                                                    name="celular" placeholder="Celular">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editar_correo">Correo</label>
                                                <input type="email" class="form-control" id="editar_correo"
                                                    name="correo" placeholder="Correo electrónico">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editar_direccion">Dirección</label>
                                                <input type="text" class="form-control" id="editar_direccion"
                                                    name="direccion" placeholder="Dirección">
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

        <div class="modal fade" id="modal_ver_persona" tabindex="-1" role="dialog"
            aria-labelledby="modalVerPersonaLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 800px;" role="document">
                <div class="modal-content p-0" style="border: none;">
                    <!-- Encabezado -->
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Información completa</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <!-- Cuerpo del modal -->
                    <div class="modal-body p-0">
                        <div class="card user-card-full">
                            <div class="row g-0">
                                <!-- Columna completa sin foto -->
                                <div class="col-sm-12 p-4">
                                    <h6 class="mb-3 pb-2 border-bottom f-w-600">Datos Generales</h6>

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <p class="mb-1 f-w-600">Tipo de Documento</p>
                                            <h6 id="ver_tipo_documento" class="text-muted f-w-400"></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="mb-1 f-w-600">Número de Documento</p>
                                            <h6 id="ver_documento" class="text-muted f-w-400"></h6>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <p class="mb-1 f-w-600">Nombres</p>
                                            <h6 id="ver_nombres" class="text-muted f-w-400"></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="mb-1 f-w-600">Apellidos</p>
                                            <h6 id="ver_apellidos" class="text-muted f-w-400"></h6>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <p class="mb-1 f-w-600">Género</p>
                                            <h6 id="ver_genero" class="text-muted f-w-400"></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="mb-1 f-w-600">Edad</p>
                                            <h6 id="ver_edad" class="text-muted f-w-400"></h6>
                                        </div>
                                    </div>



                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <p class="mb-1 f-w-600">Celular</p>
                                            <h6 id="ver_celular" class="text-muted f-w-400"></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="mb-1 f-w-600">Correo</p>
                                            <h6 id="ver_correo" class="text-muted f-w-400"></h6>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p class="mb-1 f-w-600">Dirección</p>
                                            <h6 id="ver_direccion" class="text-muted f-w-400"></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Fin modal-body -->
                </div> <!-- Fin modal-content -->
            </div>
        </div>




        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Datos personales</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_nuevapersona">Registrar</button>


                <br><br>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="tablaPersonas" class="table table-sm w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Documento</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Celular</th>
                                        <th>Correo</th>
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
            let table = $('#tablaPersonas').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('personas.listar') }}",
                    type: "GET",
                },
                order: [
                    [0, 'desc']
                ],
                columns: [{ // índice #
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1 + meta.settings._iDisplayStart;
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
                        data: 'celular'
                    },
                    {
                        data: 'correo'
                    },
                    {
                        data: 'id_persona',
                        orderable: false,
                        searchable: false,
                        render: function(id, type, row) {
                            return `
                            <button type="button"
                                class="btn btn-primary shadow btn-xs sharp me-1 btn-editar"
                                title="Editar persona"
                                data-id="${id}"
                                data-tipo_documento="${row.tipo_documento}"
                                data-documento="${row.documento}"
                                data-nombres="${row.nombres}"
                                data-apellido_paterno="${row.apellido_paterno}"
                                data-apellido_materno="${row.apellido_materno}"
                                data-genero="${row.genero}"
                                data-edad="${row.edad}"
                                data-celular="${row.celular}"
                                data-correo="${row.correo}"
                                data-direccion="${row.direccion}">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            <button type="button"
                                class="btn btn-primary shadow btn-xs sharp me-1 btn-ver"
                                title="Editar persona"
                                data-id="${id}"
                                data-tipo_documento="${row.tipo_documento}"
                                data-documento="${row.documento}"
                                data-nombres="${row.nombres}"
                                data-apellido_paterno="${row.apellido_paterno}"
                                data-apellido_materno="${row.apellido_materno}"
                                data-genero="${row.genero}"
                                data-edad="${row.edad}"
                                data-celular="${row.celular}"
                                data-correo="${row.correo}"
                                data-direccion="${row.direccion}">
                                <i class="mdi mdi-eye"></i>
                            </button>
                            


                            <form method="POST" action="/personas/${id}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger shadow btn-xs sharp me-1"
                                    onclick="return confirm('¿Eliminar esta persona?')">
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
                    lengthMenu: "&#8203; _MENU_ ",
                    search: "Buscar:",
                    zeroRecords: `<div class="text-center text-muted fw-bold py-4">
                        <i class="mdi mdi-alert-circle-outline fs-1 d-block mb-2"></i>
                        No hay resultados para tu búsqueda
                    </div>`,
                    emptyTable: `<div class="text-center text-muted fw-bold py-4">
                        <i class="mdi mdi-database-remove fs-1 d-block mb-2"></i>
                        No se encontraron asistencias registradas
                    </div>`,
                    info: " _START_ - _END_ de _TOTAL_ ",
                    infoEmpty: " 0 a 0 de 0 ",
                    infoFiltered: "(filtrado de _MAX_ registros totales)"
                },
                dom: '<"d-flex justify-content-between align-items-center"<"left-section"l><"right-section"f>>rtip'
            });

            console.log("✅ Tabla de personas inicializada");
        });
    </script>
    <script>
        $(document).on('click', '.btn-ver', function() {
            const p = $(this).data();

            $('#ver_tipo_documento').text(p.tipo_documento);
            $('#ver_documento').text(p.documento);
            $('#ver_nombres').text(p.nombres);
            $('#ver_apellidos').text(`${p.apellido_paterno} ${p.apellido_materno}`);
            $('#ver_genero').text(p.genero === 'M' ? 'Masculino' : 'Femenino');
            $('#ver_edad').text(p.edad);
            $('#ver_direccion').text(p.direccion ?? '—');

            // Celular con enlace a WhatsApp
            const celular = p.celular ? String(p.celular) : '—';
            $('#ver_celular').html(
                celular !== '—' ?
                `${celular} <a href="https://wa.me/51${celular.replace(/\D/g, '')}" target="_blank" title="Abrir en WhatsApp" style="color: green; margin-left: 5px;">
                    <i class="mdi mdi-whatsapp"></i>
                </a>` :
                '—'
            );

            // Correo con enlace mailto
            const correo = p.correo ? String(p.correo) : '—';
            $('#ver_correo').html(
                correo !== '—' ?
                `<a href="mailto:${correo}" style="text-decoration: none;">${correo} <i class="mdi mdi-email-outline" style="color: red; margin-left: 5px;"></i></a>` :
                '—'
            );

            $('#modal_ver_persona').modal('show');
        });
    </script>


    <script>
        $(document).on('click', '.btn-editar', function() {
            const persona = $(this).data();

            $('#editar_id_persona').val(persona.id);
            $('#editar_tipo_documento').val(persona.tipo_documento);
            $('#editar_documento').val(persona.documento);
            $('#editar_nombres').val(persona.nombres);
            $('#editar_apellido_paterno').val(persona.apellido_paterno);
            $('#editar_apellido_materno').val(persona.apellido_materno);
            $('#editar_genero').val(persona.genero);
            $('#editar_edad').val(persona.edad);
            $('#editar_celular').val(persona.celular);
            $('#editar_correo').val(persona.correo);
            $('#editar_direccion').val(persona.direccion);

            const action = `/personas/${persona.id}`;
            $('#formEditarPersona').attr('action', action);

            $('#modal_editarpersona').modal('show');
        });
    </script>

@endsection
