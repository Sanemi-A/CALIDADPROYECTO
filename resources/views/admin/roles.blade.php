@extends('recursos.barra')
@section('title', 'Roles | Ceinfo')
@section('roles')
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
                                    href="{{ route('roles') }}" role="tab" aria-controls="overview"
                                    aria-selected="true">Roles</a>
                            </li>

                        </ul>

                    </div>

                </div>
            </div>
        </div>
        <br>
        <div class="modal fade" id="modal_rol" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;" role="document">
                <div class="modal-content">
                    <!-- Encabezado del modal -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Nuevo registro</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Cuerpo del modal con el formulario -->
                    <div class="modal-body">

                        <div class="card">
                            <div class="card-body">


                                <form class="forms-sample" method="POST" action="{{ route('roles.store') }}">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="nombre">Nombre del rol</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre"
                                                    placeholder="Nombre" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
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
        <!-- Modal Genérico para Editar -->
        <div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="modalLabelEditar"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 600px;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Editar Usuario</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="form_editar">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editar_nombre">Nombre del rol</label>
                                        <input type="text" class="form-control" id="editar_nombre" name="nombre"
                                            placeholder="Nombre" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary me-2">Actualizar</button>
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Genérico para Asignar Privilegios -->
        <div class="modal fade" id="modal_privilegios" tabindex="-1" role="dialog" aria-labelledby="modalLabelPrivilegios"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 900px;" role="document">
                <div class="modal-content">
                    <!-- Encabezado del modal -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="titulo_modal_privilegios"><b>Asignar Privilegios</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Cuerpo del modal -->
                    <div class="modal-body">
                        <form method="POST" id="form_privilegios">
                            @csrf

                            <div id="contenedor_modulos">
                                <!-- Aquí se cargarán dinámicamente los módulos y submódulos -->
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bi bi-check-circle me-1"></i> Guardar Privilegios
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-1"></i> Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>





        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Roles</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_rol">Agregar</button>



                <br><br>

                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre del Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $rol)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $rol->nombre }}</td>

                                            <td>
                                                <!-- Botón editar -->
                                                <a href="#"
                                                    class="btn btn-primary shadow btn-xs sharp me-1 btn-editar-rol"
                                                    data-id="{{ $rol->id }}" data-nombre="{{ $rol->nombre }}"
                                                    data-bs-toggle="modal" data-bs-target="#modal_editar">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>

                                                <!-- Formulario eliminar -->
                                                <form action="{{ route('roles.destroy', $rol->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger shadow btn-xs sharp me-1"
                                                        onclick="return confirm('¿Estás seguro de eliminar este rol?')">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

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

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const botonesPrivilegios = document.querySelectorAll('.btn-privilegios');

            botonesPrivilegios.forEach(boton => {
                boton.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const nombre = this.getAttribute('data-nombre');

                    // Actualizar el título
                    document.getElementById('titulo_modal_privilegios').innerHTML =
                        `<b>Asignar Privilegios a Rol: ${nombre}</b>`;

                    // Actualizar el action del formulario
                    const form = document.getElementById('form_privilegios');
                    form.action = `/roles/${id}/assign-privileges`;

                    // Limpiar contenedor
                    const contenedor = document.getElementById('contenedor_modulos');
                    contenedor.innerHTML = '<p class="text-muted">Cargando módulos...</p>';

                    // Petición AJAX para obtener módulos y submódulos
                    fetch(`/roles/${id}/privilegios`)
                        .then(response => response.json())
                        .then(data => {
                            contenedor.innerHTML = ''; // Limpia lo anterior

                            if (data.modulos.length === 0) {
                                contenedor.innerHTML =
                                    '<p class="text-center text-muted">No hay módulos disponibles.</p>';
                                return;
                            }

                            let html = '<div class="accordion" id="modulosAccordion">';

                            data.modulos.forEach((modulo, index) => {
                                html += `
                                <div class="accordion-item border-0 mb-3 shadow-sm">
                                    <h2 class="accordion-header" id="heading${index}">
                                        <button class="accordion-button ${index > 0 ? 'collapsed' : ''} fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="${index === 0}" aria-controls="collapse${index}">
                                            ${modulo.nombre_modulo}
                                        </button>
                                    </h2>
                                    <div id="collapse${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" aria-labelledby="heading${index}" data-bs-parent="#modulosAccordion">
                                        <div class="accordion-body bg-white">
                                            <div class="row">
                                `;

                                modulo.submodulos.forEach(submodulo => {
                                    html +=
                                        `
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="border rounded p-3 bg-white shadow-sm">
                                            <h6 class="mb-3 fw-semibold text-primary">${submodulo.nombre_submodulo}</h6>`;

                                    ['leer', 'crear', 'editar', 'eliminar']
                                    .forEach(accion => {
                                        const checked = submodulo
                                            .privilegios.includes(
                                                accion) ? 'checked' :
                                            '';
                                        html += `
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="${accion}_${submodulo.id_submodulo}">${accion.charAt(0).toUpperCase() + accion.slice(1)}</label>
                                            <input class="form-check-input ms-2" type="checkbox" name="privilegios[${submodulo.id_submodulo}][${accion}]" id="${accion}_${submodulo.id_submodulo}" ${checked}>
                                        </div>
                                        `;
                                    });

                                    html += `</div></div>`;
                                });

                                html += `</div></div></div>`;
                            });

                            html += '</div>';
                            contenedor.innerHTML = html;
                        })
                        .catch(error => {
                            contenedor.innerHTML =
                                '<p class="text-danger">Error al cargar módulos.</p>';
                            console.error(error);
                        });
                });
            });
        });
    </script> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const botonesPrivilegios = document.querySelectorAll('.btn-privilegios');

            botonesPrivilegios.forEach(boton => {
                boton.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const nombre = this.getAttribute('data-nombre');

                    // Actualizar el título
                    document.getElementById('titulo_modal_privilegios').innerHTML =
                        `<b>Asignar Privilegios a Rol: ${nombre}</b>`;

                    // Actualizar el action del formulario
                    const form = document.getElementById('form_privilegios');
                    form.action = `/roles/${id}/assign-privileges`;

                    // Limpiar contenedor
                    const contenedor = document.getElementById('contenedor_modulos');
                    contenedor.innerHTML = '<p class="text-muted">Cargando módulos...</p>';

                    // Petición AJAX para obtener módulos y submódulos
                    fetch(`/roles/${id}/privilegios`)
                        .then(response => response.json())
                        .then(data => {
                            contenedor.innerHTML = ''; // Limpia lo anterior

                            if (data.modulos.length === 0) {
                                contenedor.innerHTML =
                                    '<p class="text-center text-muted">No hay módulos disponibles.</p>';
                                return;
                            }

                            let html = '<div class="accordion" id="modulosAccordion">';

                            data.modulos.forEach((modulo, index) => {
                                html += `
                                    <div class="accordion-item border-0 mb-3 shadow-sm">
                                        <h2 class="accordion-header" id="heading${index}">
                                            <button class="accordion-button ${index > 0 ? 'collapsed' : ''} fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="${index === 0}" aria-controls="collapse${index}">
                                                ${modulo.nombre_modulo}
                                            </button>
                                        </h2>
                                        <div id="collapse${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" aria-labelledby="heading${index}" data-bs-parent="#modulosAccordion">
                                            <div class="accordion-body bg-white">
                                                <div class="row">
                                `;

                                modulo.submodulos.forEach(submodulo => {
                                    html += `
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="border rounded p-3 bg-white shadow-sm">
                                                <h6 class="mb-3 fw-semibold text-primary">${submodulo.nombre_submodulo}</h6>
                                    `;

                                    // SOLO LEER
                                    const checked = submodulo.privilegios
                                        .includes('leer') ? 'checked' : '';
                                    html += `
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-check-label" for="leer_${submodulo.id_submodulo}">Ver</label>
                                            <input class="form-check-input ms-2" type="checkbox" name="privilegios[${submodulo.id_submodulo}][leer]" id="leer_${submodulo.id_submodulo}" ${checked}>
                                        </div>
                                    `;

                                    html += `</div></div>`;
                                });

                                html += `</div></div></div>`;
                            });

                            html += '</div>';
                            contenedor.innerHTML = html;
                        })
                        .catch(error => {
                            contenedor.innerHTML =
                                '<p class="text-danger">Error al cargar módulos.</p>';
                            console.error(error);
                        });
                });
            });
        });
    </script> --}}

@endsection
