@extends('recursos.barra')
@section('title', 'Matriculas | Ceinfo')
@section('matriculas')

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
                                    href="{{ route('matriculas') }}" role="tab" aria-controls="overview"
                                    aria-selected="true">Matriculas</a>
                            </li>

                        </ul>

                    </div>

                </div>
            </div>
        </div>
        <br>

        <div class="modal fade" id="modal_nueva_matricula" tabindex="-1" aria-labelledby="modalMatriculaLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 700px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Registrar Matrícula</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="{{ route('matriculas.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Buscar Estudiante -->
                            <div class="form-group mb-3">
                                <label for="search_estudiante">Buscar Estudiante</label>
                                <div class="input-group position-relative">
                                    <input type="text" class="form-control" id="search_estudiante"
                                        name="search_estudiante" placeholder="Ingrese DNI, nombre o apellido"
                                        autocomplete="off" minlength="4">
                                    <button type="button" class="clear-search d-none" id="clear-search-est"
                                        title="Limpiar búsqueda">&times;</button>
                                </div>
                                <input type="hidden" id="id_estudiante" name="id_estudiante">
                                <div id="search-results-estudiante" class="list-group" style="font-size: 0.875rem;"></div>
                            </div>

                            <!-- Horario y Fecha de Matrícula -->
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="id_horario">Horario</label>
                                        <select name="id_horario" id="id_horario" class="form-select" required>
                                            <option value="">Seleccione un horario</option>
                                            @foreach ($horarios as $horario)
                                                <option value="{{ $horario->id_horario }}">
                                                    {{ $horario->nombre_curso }} ({{ $horario->hora_inicio }} -
                                                    {{ $horario->hora_fin }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="fecha_registro">Fecha de Matrícula</label>
                                        <input type="date" class="form-control" name="fecha_registro" id="fecha_registro"
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Tipo de Entrega y Código de Pago -->
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="tipo_entrega">Tipo de Entrega</label>
                                        <select name="tipo_entrega" id="tipo_entrega" class="form-select">
                                            <option value="fisico" selected>Físico</option>
                                            <option value="virtual">Virtual</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cod_pago">Código de Pago Interno</label>
                                        <input type="text" name="cod_pago" id="cod_pago" class="form-control"
                                            placeholder="Ej: REF-1234">
                                    </div>
                                </div>
                            </div>

                            <!-- Pago -->
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="entidad_pago">Entidad de Pago</label>
                                        <input type="text" name="entidad_pago" id="entidad_pago" class="form-control"
                                            placeholder="Ej: Caja 1">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="codigo_operacion">Código de Operación</label>
                                        <input type="text" name="codigo_operacion" id="codigo_operacion"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="monto">Monto Pagado</label>
                                <input type="number" name="monto" id="monto" class="form-control" step="0.01"
                                    placeholder="Ej: 150.00">
                            </div>

                            <div class="form-group mb-3">
                                <label for="voucher">Voucher (matrícula)</label>
                                <input type="file" name="ruta_voucher" id="voucher" class="form-control">
                            </div>

                            <!-- Observación -->
                            <div class="form-group mb-3">
                                <label for="observacion">Observación</label>
                                <textarea name="observacion" id="observacion" rows="2" class="form-control" placeholder="Opcional"></textarea>
                            </div>

                            <!-- Checkbox para pago completo -->
                            <div class="form-group mb-3 d-flex justify-content-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="pago_completo"
                                        id="pago_completo">
                                    <label class="form-check-label ms-2" for="pago_completo">
                                        ¿Pago completo (matrícula + mensualidades)?
                                    </label>
                                </div>
                            </div>
                            <div class="form-group mb-3" id="grupo_voucher_mensualidades_registro"
                                style="display: none;">
                                <label for="voucher_mensualidades" class="form-label">Subir voucher de
                                    mensualidades</label>
                                <input type="file" class="form-control" name="voucher_mensualidades"
                                    id="voucher_mensualidades" accept="application/pdf,image/*">
                            </div>


                            <!-- Switch para activar beca centrado -->
                            <div class="d-flex justify-content-center mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="activarBecaSwitch">
                                    <label class="form-check-label ms-2" for="activarBecaSwitch">¿Activar beca?</label>
                                </div>
                            </div>

                            <!-- Datos de beca (inicialmente ocultos) -->
                            <div id="seccionBeca" class="d-none">
                                <div class="form-group mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="tipo_beca">Tipo de Beca</label>
                                            <input type="text" name="tipo_beca" id="tipo_beca" class="form-control"
                                                placeholder="Ej: BECA PARCIAL" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="descuento_beca">% Descuento</label>
                                            <input type="number" name="descuento_beca" id="descuento_beca"
                                                class="form-control" min="0" max="100" placeholder="Ej: 50"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="ruta_documento">Documento de Beca</label>
                                    <input type="file" name="ruta_documento" id="ruta_documento" class="form-control"
                                        disabled>
                                </div>
                            </div>




                            <!-- Botones -->
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Guardar Matrícula</button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="modal_editar_matricula" tabindex="-1" aria-labelledby="modalEditarMatriculaLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 700px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Editar Matrícula</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <form id="formEditarMatricula" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="editar_id_matricula" name="id_matricula">

                            <!-- Estudiante (solo lectura) -->
                            <div class="form-group mb-3">
                                <label>Estudiante</label>
                                <input type="text" id="editar_estudiante" class="form-control" disabled>
                            </div>

                            <!-- Horario y Fecha -->
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="editar_id_horario">Horario</label>
                                        <select name="id_horario" id="editar_id_horario" class="form-select" required>
                                            <option value="">Seleccione un horario</option>
                                            @foreach ($horarios as $horario)
                                                <option value="{{ $horario->id_horario }}">
                                                    {{ $horario->nombre_curso }} ({{ $horario->hora_inicio }} -
                                                    {{ $horario->hora_fin }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="editar_fecha_registro">Fecha de Matrícula</label>
                                        <input type="date" class="form-control" name="fecha_registro"
                                            id="editar_fecha_registro" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Entrega y Código -->
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="editar_tipo_entrega">Tipo de Entrega</label>
                                        <select name="tipo_entrega" id="editar_tipo_entrega" class="form-select">
                                            <option value="fisico">Físico</option>
                                            <option value="virtual">Virtual</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="editar_cod_pago">Código de Pago Interno</label>
                                        <input type="text" name="cod_pago" id="editar_cod_pago" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- Entidad y operación -->
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="editar_entidad_pago">Entidad de Pago</label>
                                        <input type="text" name="entidad_pago" id="editar_entidad_pago"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="editar_codigo_operacion">Código de Operación</label>
                                        <input type="text" name="codigo_operacion" id="editar_codigo_operacion"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- Monto y voucher -->
                            <div class="form-group mb-3">
                                <label for="editar_monto">Monto Pagado</label>
                                <input type="number" name="monto" id="editar_monto" class="form-control"
                                    step="0.01">
                            </div>

                            <div class="form-group mb-3">
                                <label for="editar_voucher">Voucher (archivo nuevo si desea reemplazar)</label>
                                <input type="file" name="ruta_voucher" id="editar_voucher" class="form-control">
                            </div>

                            <!-- Observación -->
                            <div class="form-group mb-3">
                                <label for="editar_observacion">Observación</label>
                                <textarea name="observacion" id="editar_observacion" rows="2" class="form-control"></textarea>
                            </div>

                            <!-- Pago completo -->
                            <div class="form-group mb-3 d-flex justify-content-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="pago_completo"
                                        id="editar_pago_completo">
                                    <label class="form-check-label ms-2" for="editar_pago_completo">
                                        ¿Pago completo (matrícula + mensualidades)?
                                    </label>
                                </div>
                            </div>

                            <!-- Campo oculto por defecto -->
                            <div class="form-group mb-3" id="grupo_voucher_mensualidades_editar" style="display: none;">
                                <label for="editar_voucher_mensualidades">Voucher Mensualidades (archivo nuevo si desea
                                    reemplazar)</label>
                                <input type="file" name="ruta_voucher_mensualidades" id="editar_voucher_mensualidades"
                                    class="form-control">
                            </div>


                            <!-- Switch beca -->
                            <div class="d-flex justify-content-center mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="editar_activar_beca">
                                    <label class="form-check-label ms-2" for="editar_activar_beca">¿Activar beca?</label>
                                </div>
                            </div>

                            <!-- Datos beca -->
                            <div id="editar_seccion_beca" class="d-none">
                                <div class="form-group mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="editar_tipo_beca">Tipo de Beca</label>
                                            <input type="text" name="tipo_beca" id="editar_tipo_beca"
                                                class="form-control" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editar_descuento_beca">% Descuento</label>
                                            <input type="number" name="descuento_beca" id="editar_descuento_beca"
                                                class="form-control" min="0" max="100" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="editar_ruta_documento">Documento de Beca</label>
                                    <input type="file" name="ruta_documento" id="editar_ruta_documento"
                                        class="form-control" disabled>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Actualizar Matrícula</button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="modal_ver_matricula" tabindex="-1" role="dialog"
            aria-labelledby="modalVerMatriculaLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-primary text-white py-4 px-5 rounded-top-4">
                        <h4 class="modal-title fw-bold text-shadow-sm">
                            <i class="mdi mdi-information-outline me-3 fs-3 align-middle"></i>Detalles de la Matrícula
                        </h4>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body bg-light-subtle px-5 py-5">
                        <h5
                            class="text-uppercase text-secondary pb-2 mb-4 border-bottom border-secondary-subtle d-flex align-items-center">
                            <i class="mdi mdi-account-circle-outline me-2 fs-5 text-primary"></i> Datos del Estudiante
                        </h5>
                        <div class="row mb-5 gx-5">
                            <div class="col-md-6">
                                <label class="form-label text-muted fw-semibold mb-1 small">NOMBRE COMPLETO</label>
                                <p id="ver_nombre_completo" class="text-dark fs-6 mb-0 lh-base"></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted fw-semibold mb-1 small">DOCUMENTO</label>
                                <p id="ver_documento_estudiante" class="text-dark fs-6 mb-0 lh-base"></p>
                            </div>
                        </div>

                        <h5
                            class="text-uppercase text-secondary pb-2 mb-4 border-bottom border-secondary-subtle d-flex align-items-center">
                            <i class="mdi mdi-book-education-outline me-2 fs-5 text-primary"></i> Curso y Horario
                        </h5>
                        <div class="row mb-4 gx-5">
                            <div class="col-md-4">
                                <label class="form-label text-muted fw-semibold mb-1 small">CURSO</label>
                                <p id="ver_nombre_curso" class="text-dark fs-6 mb-0 lh-base"></p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted fw-semibold mb-1 small">NIVEL</label>
                                <p id="ver_nivel" class="text-dark fs-6 mb-0 lh-base"></p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted fw-semibold mb-1 small">PROGRAMA</label>
                                <p id="ver_programa" class="text-dark fs-6 mb-0 lh-base"></p>
                            </div>
                        </div>

                        <div class="row mb-5 gx-5">
                            <div class="col-md-4">
                                <label class="form-label text-muted fw-semibold mb-1 small">MODALIDAD</label>
                                <p id="ver_modalidad" class="text-dark fs-6 mb-0 lh-base"></p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted fw-semibold mb-1 small">DURACIÓN</label>
                                <p id="ver_duracion_meses" class="text-dark fs-6 mb-0 lh-base"></p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted fw-semibold mb-1 small">HORARIO</label>
                                <p id="ver_horario" class="text-dark fs-6 mb-0 lh-base"></p>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label text-muted fw-semibold mb-1 small">DÍAS DE CLASE</label>
                            <p id="ver_dias" class="text-dark fs-6 mb-0 lh-base"></p>
                        </div>

                        <h5
                            class="text-uppercase text-secondary pb-2 mb-4 border-bottom border-secondary-subtle d-flex align-items-center">
                            <i class="mdi mdi-currency-usd me-2 fs-5 text-primary"></i> Información de Pago
                        </h5>
                        <div class="row mb-4 gx-5">
                            <div class="col-md-4">
                                <label class="form-label text-muted fw-semibold mb-1 small">TIPO DE ENTREGA</label>
                                <p id="ver_tipo_entrega" class="text-dark fs-6 mb-0 lh-base"></p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted fw-semibold mb-1 small">MONTO</label>
                                <p id="ver_monto" class="text-dark fs-6 mb-0 lh-base"></p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted fw-semibold mb-1 small">PAGO COMPLETO</label>
                                <p id="ver_pago_completo" class="text-dark fs-6 mb-0 lh-base"></p>
                            </div>
                        </div>

                        <div class="row mb-4 gx-5">
                            <div class="col-md-6">
                                <label class="form-label text-muted fw-semibold mb-1 small">ENTIDAD DE PAGO</label>
                                <p id="ver_entidad_pago" class="text-dark fs-6 mb-0 lh-base"></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted fw-semibold mb-1 small">CÓDIGO DE OPERACIÓN</label>
                                <p id="ver_codigo_operacion" class="text-dark fs-6 mb-0 lh-base"></p>
                            </div>
                        </div>

                        <div class="row mb-5 gx-5">
                            <div class="col-md-6">
                                <label class="form-label text-muted fw-semibold mb-1 small">VOUCHER MATRÍCULA</label>
                                <div><a href="#" target="_blank" id="ver_voucher_link"
                                        class="text-decoration-underline text-primary fw-medium"><i
                                            class="mdi mdi-file-pdf-box me-1"></i> Ver archivo PDF</a></div>
                            </div>
                            <div class="col-md-6" id="seccion_voucher_mensualidades">
                                <label class="form-label text-muted fw-semibold mb-1 small">VOUCHER MENSUALIDADES</label>
                                <div>
                                    <a href="#" target="_blank" id="ver_voucher_mensualidades_link"
                                        class="text-decoration-underline text-primary fw-medium">
                                        <i class="mdi mdi-file-pdf-box me-1"></i> Ver archivo PDF
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div id="seccion_beca">
                            <h5
                                class="text-uppercase text-secondary pb-2 mb-4 border-bottom border-secondary-subtle d-flex align-items-center">
                                <i class="mdi mdi-medal-outline me-2 fs-5 text-primary"></i> Información de Beca
                            </h5>
                            <div class="row mb-5 gx-5">
                                <div class="col-md-6">
                                    <label class="form-label text-muted fw-semibold mb-1 small">TIPO DE BECA</label>
                                    <p id="ver_tipo_beca" class="text-dark fs-6 mb-0 lh-base"></p>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted fw-semibold mb-1 small">% DESCUENTO</label>
                                    <p id="ver_descuento_beca" class="text-dark fs-6 mb-0 lh-base"></p>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted fw-semibold mb-1 small">DOCUMENTO</label>
                                    <div><a href="#" target="_blank" id="ver_documento_beca_link"
                                            class="text-decoration-underline text-primary fw-medium"><i
                                                class="mdi mdi-file-pdf-box me-1"></i> Ver documento PDF</a></div>
                                </div>
                            </div>
                        </div>

                        <h5
                            class="text-uppercase text-secondary pb-2 mb-4 border-bottom border-secondary-subtle d-flex align-items-center">
                            <i class="mdi mdi-comment-text-multiple-outline me-2 fs-5 text-primary"></i> Observaciones
                        </h5>
                        <div class="bg-white p-4 rounded-3 mb-5 border border-light-subtle shadow-sm">
                            <p id="ver_observacion" class="text-muted mb-0 fst-italic small"></p>
                        </div>

                        <h5
                            class="text-uppercase text-secondary pb-2 mb-4 border-bottom border-secondary-subtle d-flex align-items-center">
                            <i class="mdi mdi-check-decagram me-2 fs-5 text-primary"></i> Estado de la Matrícula
                        </h5>
                        <div class="row gx-5">
                            <div class="col-md-6">
                                <label class="form-label text-muted fw-semibold mb-1 small">ESTADO</label>
                                <p id="ver_estado" class="text-dark fs-6 mb-0 lh-base"></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted fw-semibold mb-1 small">VALIDADO</label>
                                <p id="ver_validado" class="text-dark fs-6 mb-0 lh-base"></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>





        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Matriculas</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_nueva_matricula">Registrar</button>


                <br><br>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="tablaMatriculas" class="table table-sm w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Estudiante</th>
                                        <th>Curso</th>
                                        <th>Fecha Matrícula</th>
                                        <th>Estado</th>
                                        <th>Respnsable</th>
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
            let table = $('#tablaMatriculas').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('matriculas.listar') }}",
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
                        render: function(row) {
                            let documento = row.documento || '---';
                            let nombres =
                                `${row.estudiante_nombres} ${row.estudiante_apellido_paterno} ${row.estudiante_apellido_materno}`;
                            return `
                                    <div class="position-relative" style="padding-top: 1.2rem;">
                                        <span class="badge badge-opacity-info" style="
                                            position: absolute;
                                            top: 0;
                                            left: 0;
                                            font-size: 0.6rem;
                                            padding: 0.2em 0.4em;
                                            line-height: 1;
                                            z-index: 1;
                                        ">${documento}</span>
                                        <p class="mb-0 fw-semibold" style="font-size: 0.875rem;">${nombres}</p>
                                    </div>
                                `;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let nivel = row.nivel ? row.nivel.toUpperCase() : 'SIN NIVEL';
                            let programa = row.programa ? row.programa.toUpperCase() :
                                'SIN PROGRAMA';

                            let nivelColor = {
                                'BÁSICO': 'badge badge-opacity-primary',
                                'INTERMEDIO': 'badge badge-opacity-warning',
                                'AVANZADO': 'badge badge-opacity-success'
                            };

                            let claseNivel = nivelColor[nivel] || 'badge badge-opacity-secondary';

                            return `
                                <div class="position-relative" style="padding-top: 1.5rem;">
                                    <div class="position-absolute top-0  d-flex gap-1">
                                        <span class="${claseNivel}" style="
                                            font-size: 0.6rem;
                                            padding: 0.2em 0.4em;
                                            line-height: 1;
                                        ">${nivel}</span>
                                        <span class="badge badge-warning border" style="
                                            font-size: 0.6rem;
                                            padding: 0.2em 0.4em;
                                            line-height: 1;
                                        ">${programa}</span>
                                    </div>
                                    <p class="mb-0 fw-semibold" style="font-size: 0.875rem;">${row.nombre_curso}</p>
                                </div>
                            `;
                        }
                    },

                    {
                        data: 'fecha_registro',
                        render: function(fecha) {
                            return `<small>${fecha}</small>`;
                        }
                    },
                    {
                        data: 'estado',
                        render: function(estado) {
                            let colores = {
                                'VIGENTE': 'success',
                                'FINALIZADA': 'primary',
                                'CANCELADA': 'danger',
                                'RETIRADA': 'warning'
                            };
                            let clase = colores[estado] || 'secondary';
                            return `<span class="badge bg-${clase}">${estado}</span>`;
                        }
                    },
                    {
                        data: 'responsable',
                        render: function(responsable) {
                            return responsable ?
                                `<span class="badge bg-info text-dark">${responsable}</span>` :
                                `<span class="badge bg-secondary">No registrado</span>`;
                        }
                    },

                    {
                        data: 'id_matricula',
                        orderable: false,
                        searchable: false,
                        render: function(id, type, row) {
                            return `
                                <button type="button" class="btn btn-info shadow btn-xs sharp me-1 btn-ver-matricula"
                                    title="Ver matrícula"
                                    data-id="${id}"
                                    data-estudiante="${row.estudiante_nombres} ${row.estudiante_apellido_paterno} ${row.estudiante_apellido_materno}"
                                    data-documento="${row.documento}"
                                    data-nombre_curso="${row.nombre_curso}"
                                    data-nivel="${row.nivel}"
                                    data-programa="${row.programa}"
                                    data-modalidad="${row.modalidad}"
                                    data-duracion_meses="${row.duracion_meses}"
                                    data-hora_inicio="${row.hora_inicio}"
                                    data-hora_fin="${row.hora_fin}"
                                    data-lunes="${row.lunes}"
                                    data-martes="${row.martes}"
                                    data-miercoles="${row.miercoles}"
                                    data-jueves="${row.jueves}"
                                    data-viernes="${row.viernes}"
                                    data-sabado="${row.sabado}"
                                    data-domingo="${row.domingo}"
                                    data-fecha_registro="${row.fecha_registro}"
                                    data-tipo_entrega="${row.tipo_entrega}"
                                    data-monto="${row.monto ?? ''}"
                                    data-entidad_pago="${String(row.entidad_pago ?? '').replace(/"/g, '&quot;')}"
                                    data-codigo_operacion="${String(row.codigo_operacion ?? '').replace(/"/g, '&quot;')}"
                                    data-cod_pago="${String(row.cod_pago ?? '').replace(/"/g, '&quot;')}"
                                    data-pago_completo="${row.pago_completo}"
                                    data-observacion="${String(row.observacion ?? '').replace(/"/g, '&quot;')}"
                                    data-tipo_beca="${String(row.tipo_beca ?? '').replace(/"/g, '&quot;')}"
                                    data-descuento_beca="${row.descuento_beca ?? ''}"
                                    data-documento_beca="${String(row.documento_beca ?? '').replace(/"/g, '&quot;')}"
                                    data-ruta_documento="${String(row.ruta_documento ?? '').replace(/"/g, '&quot;')}"
                                    data-ruta_voucher="${String(row.ruta_voucher ?? '').replace(/"/g, '&quot;')}"
                                    data-ruta_voucher_mensualidades="${String(row.ruta_voucher_mensualidades ?? '').replace(/"/g, '&quot;')}"
                                    data-estado="${row.estado}"
                                    data-validado="${row.validado ? 'Sí' : 'No'}"
                                >
                                    <i class="mdi mdi-eye"></i>
                                </button>

                                <button type="button" class="btn btn-primary shadow btn-xs sharp me-1 btn-editar-matricula"
                                    title="Editar matrícula"
                                    data-id="${id}"
                                    data-id_estudiante="${row.id_estudiante}"
                                    data-id_horario="${row.id_horario}"
                                    data-fecha_registro="${row.fecha_registro}"
                                    data-tipo_entrega="${row.tipo_entrega}"
                                    data-cod_pago="${String(row.cod_pago ?? '').replace(/"/g, '&quot;')}"
                                    data-entidad_pago="${String(row.entidad_pago ?? '').replace(/"/g, '&quot;')}"
                                    data-codigo_operacion="${String(row.codigo_operacion ?? '').replace(/"/g, '&quot;')}"
                                    data-monto="${row.monto ?? ''}"
                                    data-observacion="${String(row.observacion ?? '').replace(/"/g, '&quot;')}"
                                    data-pago_completo="${row.pago_completo}"
                                    data-tipo_beca="${String(row.tipo_beca ?? '').replace(/"/g, '&quot;')}"
                                    data-descuento_beca="${row.descuento_beca ?? ''}"
                                    data-documento_beca="${String(row.documento_beca ?? '').replace(/"/g, '&quot;')}"
                                    data-ruta_documento="${String(row.ruta_documento ?? '').replace(/"/g, '&quot;')}"
                                >
                                    <i class="mdi mdi-pencil"></i>
                                </button>

                                <form method="POST" action="/matriculas/${id}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger shadow btn-xs sharp me-1"
                                        onclick="return confirm('¿Eliminar esta matrícula?')">
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
                    No hay matrículas registradas
                </div>`,
                    info: "_START_ - _END_ de _TOTAL_",
                    infoEmpty: "0 a 0 de 0",
                    infoFiltered: "(filtrado de _MAX_ registros totales)"
                },
                dom: '<"d-flex justify-content-between align-items-center"<"left-section"l><"right-section"f>>rtip'
            });

            console.log("✅ Tabla de matrículas inicializada");
        });
    </script>

    <script>
        $(document).ready(function() {
            // Buscar estudiante cuando se escribe en el input
            $('#search_estudiante').on('keyup', function() {
                let query = $(this).val().trim();

                if (query.length >= 4) {
                    $.ajax({
                        url: "{{ route('estudiantes.buscar') }}", // Ruta para estudiantes
                        type: 'GET',
                        data: {
                            query: query
                        },
                        dataType: 'json',
                        success: function(data) {
                            let resultContainer = $('#search-results-estudiante');
                            resultContainer.html('');

                            if (data.length > 0) {
                                data.forEach(function(item) {
                                    resultContainer.append(`
                                    <a href="#" class="list-group-item list-group-item-action result-estudiante"
                                        data-id="${item.id_estudiante}"
                                        data-documento="${item.documento}">
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
                            $('#search-results-estudiante').html(
                                '<p class="text-danger p-2">Error en la búsqueda</p>'
                            );
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    $('#search-results-estudiante').html('');
                }
            });

            // Seleccionar estudiante del resultado
            $(document).on('click', '.result-estudiante', function(e) {
                e.preventDefault();

                $('#search_estudiante').val($(this).text());
                $('#id_estudiante').val($(this).data('id'));
                $('#search-results-estudiante').html('');
                $('#search_estudiante').prop('disabled', true);
                $('#clear-search-est').removeClass('d-none');
            });

            // Botón de limpiar búsqueda
            $('#clear-search-est').on('click', function() {
                $('#search_estudiante').val('').prop('disabled', false).focus();
                $('#id_estudiante').val('');
                $('#search-results-estudiante').html('');
                $(this).addClass('d-none');
            });

            // Al cerrar el modal de matrícula
            $('#modal_nueva_matricula').on('hidden.bs.modal', function() {
                const form = $(this).find('form')[0];
                form.reset();

                $('#search_estudiante').prop('disabled', false).val('');
                $('#search-results-estudiante').html('');
                $('#id_estudiante').val('');
                $('#clear-search-est').addClass('d-none');
            });
        });
    </script>


    <script>
        $(document).on('click', '.btn-editar-matricula', function() {
            const btn = $(this);

            // Set action dinámico (si lo haces con JS, recuerda que route debe estar completo o usar JS para componerlo)
            let id = btn.data('id');
            $('#formEditarMatricula').attr('action', `/matriculas/${id}`);

            // Rellenar campos
            $('#editar_id_matricula').val(id);
            $('#editar_id_horario').val(btn.data('id_horario'));
            $('#editar_fecha_registro').val(btn.data('fecha_registro'));
            $('#editar_tipo_entrega').val(btn.data('tipo_entrega'));
            $('#editar_cod_pago').val(btn.data('cod_pago'));
            $('#editar_entidad_pago').val(btn.data('entidad_pago'));
            $('#editar_codigo_operacion').val(btn.data('codigo_operacion'));
            $('#editar_monto').val(btn.data('monto'));
            $('#editar_observacion').val(btn.data('observacion'));

            // Checkbox de pago completo
            $('#editar_pago_completo').prop('checked', btn.data('pago_completo') == 1);

            // Estudiante en campo de solo lectura
            const nombres = btn.closest('tr').find('td:nth-child(2) p').text(); // Ajusta si la estructura cambia
            $('#editar_estudiante').val(nombres);

            // Beca
            const tipoBeca = btn.data('tipo_beca');
            if (tipoBeca) {
                $('#editar_activar_beca').prop('checked', true);
                $('#editar_seccion_beca').removeClass('d-none');
                $('#editar_tipo_beca').val(tipoBeca).prop('disabled', false);
                $('#editar_descuento_beca').val(btn.data('descuento_beca')).prop('disabled', false);
                $('#editar_ruta_documento').prop('disabled', false);
            } else {
                $('#editar_activar_beca').prop('checked', false);
                $('#editar_seccion_beca').addClass('d-none');
                $('#editar_tipo_beca, #editar_descuento_beca, #editar_ruta_documento').val('').prop('disabled',
                    true);
            }

            // Mostrar modal
            $('#modal_editar_matricula').modal('show');
        });
        $('#editar_activar_beca').on('change', function() {
            if ($(this).is(':checked')) {
                $('#editar_seccion_beca').removeClass('d-none');
                $('#editar_tipo_beca').prop('disabled', false);
                $('#editar_descuento_beca').prop('disabled', false);
                $('#editar_ruta_documento').prop('disabled', false);
            } else {
                $('#editar_seccion_beca').addClass('d-none');
                $('#editar_tipo_beca, #editar_descuento_beca, #editar_ruta_documento').val('').prop('disabled',
                    true);
            }
        });
    </script>


    <script>
        $(document).on('click', '.btn-ver-matricula', function() {
            const btn = $(this);

            // Datos del estudiante
            $('#ver_nombre_completo').text(btn.data('estudiante') || '---');
            $('#ver_documento_estudiante').text(btn.data('documento') || '---');

            // Curso y horario
            $('#ver_nombre_curso').text(btn.data('nombre_curso') || '---');
            $('#ver_nivel').text(btn.data('nivel') || '---');
            $('#ver_programa').text(btn.data('programa') || '---');
            $('#ver_modalidad').text(btn.data('modalidad') || '---');
            $('#ver_duracion_meses').text(`${btn.data('duracion_meses') || 0} meses`);

            const horaInicio = btn.data('hora_inicio') || '--:--';
            const horaFin = btn.data('hora_fin') || '--:--';
            $('#ver_horario').text(`${horaInicio} - ${horaFin}`);

            // Días
            const dias = [];
            if (btn.data('lunes')) dias.push('Lunes');
            if (btn.data('martes')) dias.push('Martes');
            if (btn.data('miercoles')) dias.push('Miércoles');
            if (btn.data('jueves')) dias.push('Jueves');
            if (btn.data('viernes')) dias.push('Viernes');
            if (btn.data('sabado')) dias.push('Sábado');
            if (btn.data('domingo')) dias.push('Domingo');
            $('#ver_dias').text(dias.length ? dias.join(', ') : '---');

            // Información de pago
            $('#ver_tipo_entrega').text(btn.data('tipo_entrega') || '---');
            $('#ver_monto').text(`S/ ${btn.data('monto') || '0.00'}`);
            $('#ver_pago_completo').text(btn.data('pago_completo') ? 'Sí' : 'No');
            $('#ver_entidad_pago').text(btn.data('entidad_pago') || '---');
            $('#ver_codigo_operacion').text(btn.data('codigo_operacion') || '---');

            // Voucher
            const rutaVoucher = btn.data('ruta_voucher');
            if (rutaVoucher && rutaVoucher.trim() !== '') {
                $('#ver_voucher_link')
                    .attr('href', rutaVoucher)
                    .text('Ver archivo')
                    .removeClass('text-danger')
                    .addClass('text-primary text-decoration-underline')
                    .show();
            } else {
                $('#ver_voucher_link')
                    .attr('href', '#')
                    .text('Falta subir')
                    .removeClass('text-primary text-decoration-underline')
                    .addClass('text-danger')
                    .show();
            }
            const pagoCompleto = btn.data('pago_completo') === true || btn.data('pago_completo') === 1 || btn.data(
                'pago_completo') === '1';
            const rutaVoucherMensualidades = btn.data('ruta_voucher_mensualidades');

            if (pagoCompleto) {
                $('#seccion_voucher_mensualidades').show();

                if (rutaVoucherMensualidades && rutaVoucherMensualidades.trim() !== '') {
                    $('#ver_voucher_mensualidades_link')
                        .attr('href', rutaVoucherMensualidades)
                        .text('Ver archivo PDF')
                        .removeClass('text-danger')
                        .addClass('text-primary text-decoration-underline')
                        .show();
                } else {
                    $('#ver_voucher_mensualidades_link')
                        .attr('href', '#')
                        .text('Falta subir')
                        .removeClass('text-primary text-decoration-underline')
                        .addClass('text-danger')
                        .show(); // O puedes usar .hide() si no quieres mostrar el enlace sin archivo
                }

            } else {
                $('#seccion_voucher_mensualidades').hide();
            }




            // Beca
            const tipoBeca = btn.data('tipo_beca');
            const descuento = btn.data('descuento_beca');
            const rutaDocBeca = btn.data('ruta_documento');

            if (tipoBeca || descuento || rutaDocBeca) {
                $('#seccion_beca').show();

                $('#ver_tipo_beca').text(tipoBeca || '---');
                $('#ver_descuento_beca').text(`${descuento || 0}%`);

                if (rutaDocBeca && rutaDocBeca.trim() !== '') {
                    $('#ver_documento_beca_link')
                        .attr('href', rutaDocBeca)
                        .text('Ver documento')
                        .removeClass('text-danger')
                        .addClass('text-primary text-decoration-underline')
                        .show();
                } else {
                    $('#ver_documento_beca_link')
                        .attr('href', '#')
                        .text('Falta subir')
                        .removeClass('text-primary text-decoration-underline')
                        .addClass('text-danger')
                        .show();
                }
            } else {
                $('#seccion_beca').hide();
            }

            // Observaciones
            $('#ver_observacion').text(btn.data('observacion') || '---');

            // Estado y validado
            $('#ver_estado').text(btn.data('estado') || '---');
            $('#ver_validado').text(btn.data('validado') || 'No');

            // Mostrar modal
            $('#modal_ver_matricula').modal('show');
        });
    </script>




    <script>
        document.getElementById('activarBecaSwitch').addEventListener('change', function() {
            const isChecked = this.checked;
            const seccion = document.getElementById('seccionBeca');
            seccion.classList.toggle('d-none', !isChecked);

            document.getElementById('tipo_beca').disabled = !isChecked;
            document.getElementById('descuento_beca').disabled = !isChecked;
            document.getElementById('ruta_documento').disabled = !isChecked;
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // === REGISTRO ===
            const cbRegistro = document.getElementById('pago_completo');
            const grupoRegistro = document.getElementById('grupo_voucher_mensualidades_registro');
            const inputRegistro = document.getElementById('voucher_mensualidades');

            if (cbRegistro && grupoRegistro && inputRegistro) {
                const toggleRegistro = () => {
                    grupoRegistro.style.display = cbRegistro.checked ? 'block' : 'none';
                    if (!cbRegistro.checked) inputRegistro.value = '';
                };

                toggleRegistro();
                cbRegistro.addEventListener('change', toggleRegistro);
            }

            // === EDICIÓN ===
            const modalEditar = document.getElementById('modal_editar_matricula'); // ← ID corregido

            if (modalEditar) {
                modalEditar.addEventListener('shown.bs.modal', function() {
                    const cbEditar = document.getElementById('editar_pago_completo');
                    const grupoEditar = document.getElementById('grupo_voucher_mensualidades_editar');
                    const inputEditar = document.getElementById('editar_voucher_mensualidades');

                    if (cbEditar && grupoEditar && inputEditar) {
                        const toggleEditar = () => {
                            grupoEditar.style.display = cbEditar.checked ? 'block' : 'none';
                            if (!cbEditar.checked) inputEditar.value = '';
                        };

                        toggleEditar(); // Ejecuta al abrir el modal
                        cbEditar.removeEventListener('change', toggleEditar); // Previene duplicados
                        cbEditar.addEventListener('change', toggleEditar);
                    }
                });
            }
        });
    </script>










@endsection
