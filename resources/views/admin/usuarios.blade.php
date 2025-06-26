@extends('recursos.barra')

@section('usuarios')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link  ps-0" id="home-tab" href="{{ route('inicio') }}">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab"
                                    href="{{ route('usuarios') }}" role="tab" aria-controls="overview"
                                    aria-selected="true">Datos personales</a>
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
                    <!-- Encabezado del modal -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Nuevo Registro de Usuario</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Cuerpo del modal con el formulario -->
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form class="forms-sample" method="POST" action="{{ route('users.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <!-- Fila 1: Documento y Nombres -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dni">Documento (DNI)</label>
                                                <input type="number" class="form-control" id="dni" name="dni"
                                                    placeholder="Documento" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nombres">Nombres</label>
                                                <input type="text" class="form-control" id="nombres" name="nombres"
                                                    placeholder="Nombres" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fila 2: Apellido Paterno y Apellido Materno -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="apellido_paterno">Apellido Paterno</label>
                                                <input type="text" class="form-control" id="apellido_paterno"
                                                    name="apellido_paterno" placeholder="Apellido Paterno" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="apellido_materno">Apellido Materno</label>
                                                <input type="text" class="form-control" id="apellido_materno"
                                                    name="apellido_materno" placeholder="Apellido Materno" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fila 3: Correo Electrónico y Contraseña -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Correo Electrónico</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Correo Electrónico" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Contraseña</label>
                                                <input type="password" class="form-control" id="password" name="password"
                                                    placeholder="Contraseña" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fila 4: Foto y Rol -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="foto">Foto</label>
                                                <input type="file" class="dropify" id="foto" name="foto"
                                                    accept="image/*" data-height="150" />
                                            </div>
                                        </div>
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
                                    </div>

                                    <!-- Botones -->
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary me-2">Registrar Usuario</button>
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

                <h4 class="card-title">Datos personales</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_nuevou">Nuevo
                    usuario</button>


                <br><br>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Foto</th>
                                        <th>Dni</th>
                                        <th>Nomnres</th>
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

                                            <td>{{ $usuario->dni }}</td>
                                            <td>{{ $usuario->nombres }}</td>
                                            <td>{{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</td>
                                            <td>{{ $usuario->email }}</td>
                                            <td>{{ $usuario->role->nombre }}</td>
                                            <td>
                                                <a href="#" class="btn btn-warning shadow btn-xs sharp me-1">
                                                    <i class="mdi mdi-lock"></i>
                                                </a>
                                                <a href="{{ route('usuarios', $usuario->id) }}"
                                                    class="btn btn-primary shadow btn-xs sharp me-1">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <form action="{{ route('users.destroy', $usuario->id) }}"
                                                    method="POST" style="display: inline;">
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
@endsection
