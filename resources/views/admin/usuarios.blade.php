@extends('recursos.barra')
@section('title', 'usuarios | Ceinfo')
@section('usuarios')

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
                                    aria-selected="true">Usuarios</a>
                            </li>

                        </ul>

                    </div>

                </div>
            </div>
        </div>
        <br>

        <div class="modal fade" id="modal_nuevou" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;" role="document">
                <div class="modal-content">

                    <!-- Encabezado -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Nuevo Registro de Usuario</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Cuerpo -->
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">

                                <form class="forms-sample" method="POST" action="{{ route('users.store') }}"
                                    enctype="multipart/form-data">
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



                                    <!-- Rol y correo -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="rol_id">Rol</label>
                                                <select class="form-select" id="rol_id" name="rol_id" required>
                                                    <option value="" disabled selected>Seleccione un rol</option>
                                                    @foreach ($roles as $rol)
                                                        <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Correo Electrónico</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Correo Electrónico" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Contraseñas -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Contraseña</label>
                                                <input type="password" class="form-control" id="password" name="password"
                                                    placeholder="Contraseña" required>
                                                <small id="error-password" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirmar Contraseña</label>
                                                <input type="password" class="form-control" id="password_confirmation"
                                                    name="password_confirmation" placeholder="Confirmar Contraseña"
                                                    required>
                                                <small id="error-password-confirmation" class="text-danger"></small>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Foto -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="foto">Foto</label>
                                                <input type="file" class="dropify" id="foto" name="foto"
                                                    accept="image/*" data-height="150" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botones -->
                                    <div class="row mt-3">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary me-2" id="submit-btn_registrar"
                                                disabled>
                                                Registrar Usuario
                                            </button>
                                            <button type="reset" class="btn btn-light" data-bs-dismiss="modal"
                                                id="btnCancelarUsuario">Cancelar</button>

                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <div class="modal fade" id="modalUsuarioEditar" tabindex="-1" role="dialog"
            aria-labelledby="modalUsuarioEditarLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;" role="document">
                <div class="modal-content">

                    <!-- Encabezado -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUsuarioEditarLabel"><b>Editar Usuario</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <!-- Cuerpo -->
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">

                                <form id="formUsuarioEditar" class="forms-sample" method="POST" action=""
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" id="usuario_id_editar" name="usuario_id">

                                    <!-- Mostrar nombre completo (solo lectura) -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="nombre_usuario_editar">Usuario</label>
                                                <input type="text" class="form-control" id="nombre_usuario_editar"
                                                    name="nombre_usuario" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Rol y correo -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="rol_id_editar">Rol</label>
                                                <select class="form-select" id="rol_id_editar" name="rol_id" required>
                                                    <option value="" disabled selected>Seleccione un rol</option>
                                                    @foreach ($roles as $rol)
                                                        <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email_editar">Correo Electrónico</label>
                                                <input type="email" class="form-control" id="email_editar"
                                                    name="email" placeholder="Correo Electrónico" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Foto -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="foto_editar">Foto</label>
                                                <input type="file" class="dropify" id="foto_editar" name="foto"
                                                    accept="image/*" data-height="150" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botones -->
                                    <div class="row mt-3">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary me-2"
                                                id="btnSubmitUsuarioEditar">
                                                Guardar Cambios
                                            </button>
                                            <button type="reset" class="btn btn-light" data-bs-dismiss="modal"
                                                id="btnCancelarUsuarioEditar">Cancelar</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="modal fade" id="modalCambiarPassword" tabindex="-1" aria-labelledby="modalCambiarPasswordLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><b id="modalCambiarPasswordLabel">Cambiar Contraseña</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form id="formCambiarPassword" class="forms-sample" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="usuario_id" id="usuario_id_password">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="nueva_password">Nueva Contraseña</label>
                                                <input type="password" class="form-control" id="nueva_password"
                                                    name="password" placeholder="Nueva contraseña" required>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="confirmar_password">Confirmar Contraseña</label>
                                                <input type="password" class="form-control" id="confirmar_password"
                                                    name="password_confirmation" placeholder="Confirmar contraseña"
                                                    required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary me-2">Actualizar
                                                Contraseña</button>
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

                <h4 class="card-title">Usuarios del sistema</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_nuevou">Nuevo
                    usuario</button>


                <br><br>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Foto</th>
                                        <th>Dcoumento</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $usuario)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="py-1">
                                                <img src="{{ asset('storage/' . $usuario->foto) }}"
                                                    alt="Foto de {{ $usuario->nombres }}" width="50" height="50">
                                            </td>

                                            <td>{{ $usuario->persona->documento ?? '—' }}</td>
                                            <td>{{ $usuario->persona->nombres ?? '—' }}</td>
                                            <td>{{ $usuario->persona->apellido_paterno ?? '' }}
                                                {{ $usuario->persona->apellido_materno ?? '' }}</td>

                                            <td>{{ $usuario->email }}</td>
                                            <td>{{ $usuario->role->nombre }}</td>
                                            <td>
                                                <a href="javascript:void(0);"
                                                    class="btn btn-warning shadow btn-xs sharp me-1"
                                                    onclick='abrirModalPassword(@json($usuario))'>
                                                    <i class="mdi mdi-lock"></i>
                                                </a>

                                                <a href="#"
                                                    class="btn btn-primary shadow btn-xs sharp me-1 btn-editar"
                                                    data-id="{{ $usuario->id }}"
                                                    data-nombres="{{ $usuario->persona->nombres ?? '' }}"
                                                    data-apellido_paterno="{{ $usuario->persona->apellido_paterno ?? '' }}"
                                                    data-apellido_materno="{{ $usuario->persona->apellido_materno ?? '' }}"
                                                    data-correo="{{ $usuario->email }}"
                                                    data-rol="{{ $usuario->rol_id }}"
                                                    data-foto="{{ $usuario->foto ? asset('storage/' . $usuario->foto) : '' }}">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>



                                                <form action="{{ route('users.destroy', $usuario->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger shadow btn-xs sharp me-1"
                                                        onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
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

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <script>
        $(document).on('click', '.btn-editar', function(e) {
            e.preventDefault();

            const btn = $(this);

            const id = btn.data('id');
            const nombres = btn.data('nombres') || '';
            const apellidop = btn.data('apellido_paterno') || '';
            const apellidom = btn.data('apellido_materno') || '';
            const email = btn.data('correo');
            const rol_id = btn.data('rol');
            const fotoUrl = btn.data('foto');

            const nombreCompleto = `${nombres} ${apellidop} ${apellidom}`.trim();

            $('#usuario_id_editar').val(id);
            $('#nombre_usuario_editar').val(nombreCompleto);
            $('#email_editar').val(email);
            $('#rol_id_editar').val(rol_id).trigger('change');
            $('#formUsuarioEditar').attr('action', '/users/' + id);

            // Configurar Dropify
            let dropify = $('#foto_editar').dropify();
            dropify = dropify.data('dropify');

            dropify.resetPreview();
            dropify.clearElement();

            if (fotoUrl) {
                dropify.settings.defaultFile = fotoUrl;
            }

            dropify.destroy();
            dropify.init();

            $('#modalUsuarioEditar').modal('show');
        });
    </script>



    <script>
        function abrirModalPassword(usuario) {
            // Establecer ruta dinámica para el update de contraseña
            $('#formCambiarPassword').attr('action', '/users/' + usuario.id + '/password');
            $('#usuario_id_password').val(usuario.id);
            $('#nueva_password').val('');
            $('#confirmar_password').val('');
            $('#modalCambiarPassword').modal('show');
        }
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
                $('#email').val('');
                $('#clear-search').addClass('d-none');
                $('#submit-btn_registrar').prop('disabled', true);
            });


            // Validar contraseñas
            $('#password, #password_confirmation').on('keyup change', function() {
                validarFormulario();
            });

            function validarFormulario() {
                const idPersona = $('#id_persona').val();
                const pass = $('#password').val();
                const confirm = $('#password_confirmation').val();
                const btn = $('#submit-btn_registrar');

                if (idPersona && pass.length >= 6 && pass === confirm) {
                    btn.prop('disabled', false);
                    $('#error-password').text('');
                    $('#error-password-confirmation').text('');
                } else {
                    btn.prop('disabled', true);
                    if (pass !== confirm) {
                        $('#error-password-confirmation').text('Las contraseñas no coinciden');
                    } else {
                        $('#error-password-confirmation').text('');
                    }
                }
            }

            // Botón cancelar: limpiar y resetear todo
            $('#btnCancelarUsuario').on('click', function() {
                const form = $('form.forms-sample')[0];
                form.reset();

                $('#search').prop('disabled', false).val('');
                $('#search-results').html('');
                $('#id_persona').val('');
                $('#correo').val('');
                $('#password').val('');
                $('#password_confirmation').val('');
                $('#submit-btn_registrar').prop('disabled', true);
                $('#error-password').text('');
                $('#error-password-confirmation').text('');

                // Reset dropify (si lo estás usando)
                const dropify = $('#foto').data('dropify');
                if (dropify) dropify.resetPreview().clearElement();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Ejecutar cuando se haga reset del formulario
            $('form.forms-sample').on('reset', function() {
                // Limpiar resultados y campo de búsqueda
                $('#search').prop('disabled', false).val('');
                $('#search-results').html('');
                $('#id_persona').val('');
                $('#clear-search').addClass('d-none');

                // Limpiar errores
                $('#error-password').text('');
                $('#error-password-confirmation').text('');
                $('#submit-btn_registrar').prop('disabled', true);

                // Reset dropify si existe
                const dropify = $('#foto').data('dropify');
                if (dropify) {
                    dropify.resetPreview();
                    dropify.clearElement();
                }
            });

            // Limpiar búsqueda manual
            $('#clear-search').on('click', function() {
                $('#search').val('').prop('disabled', false).focus();
                $('#id_persona').val('');
                $('#correo').val('');
                $(this).addClass('d-none');
                $('#submit-btn_registrar').prop('disabled', true);
            });
        });
    </script>

@endsection
