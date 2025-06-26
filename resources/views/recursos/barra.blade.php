<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard | cofi</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/dropify/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-asColorPicker/css/asColorPicker.min.css') }}">


    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-toast-plugin/jquery.toast.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/select.dataTables.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- endinject -->
    <link rel="shortcut icon" href="assets/images/logo.png" />
    <style>
        /* Reducir el tamaño de la letra de los botones de paginación */
        .dataTables_paginate .paginate_button {
            font-size: 6px;
            /* Ajusta el tamaño de la fuente aquí */
        }

        /* También puedes ajustar el tamaño de los iconos de las flechas, si es necesario */
        .dataTables_paginate .paginate_button i {
            font-size: 12px;
            /* Ajusta el tamaño de los iconos de las flechas */
        }

        /* Cambiar tamaño de la letra en el botón activo */
        .dataTables_paginate .paginate_button.current {
            font-size: 6px;
            /* Asegurarse de que el tamaño del texto del botón activo también sea pequeño */
        }
    </style>


</head>

<body class="with-welcome-text">
    <div class="container-scroller">

        <!-- partial:partials/_navbar.html -->
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <div class="me-3">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-bs-toggle="minimize">
                        <span class="icon-menu"></span>
                    </button>
                </div>
                <div>
                    <a class="navbar-brand brand-logo" href="index.html">
                        <img src="{{ asset('storage/sistema/CEINFO_LOGO.png') }}" alt="logo" />

                    </a>
                    <a class="navbar-brand brand-logo-mini" href="index.html">

                    </a>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-top">
                <ul class="navbar-nav">
                    @isset($saludo)
                        <li class="nav-item fw-semibold d-none d-lg-block ms-0">
                            <h1 class="welcome-text" id="saludo">
                                {{ $saludo }}, <span class="text-black fw-bold" id="user-name">{{ $user->nombres }}
                                    {{ $user->apellido_paterno }} {{ $user->apellido_materno }}</span>
                            </h1>
                            <h3 class="welcome-sub-text"></h3>
                        </li>
                    @endisset
                </ul>


                <ul class="navbar-nav ms-auto">


                    <li class="nav-item d-none d-lg-block">
                        <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
                            <span class="input-group-addon input-group-prepend border-right">
                                <span class="icon-calendar input-group-text calendar-icon"></span>
                            </span>
                            <input type="text" class="form-control">
                        </div>
                    </li>
                    <li class="nav-item">
                        <form class="search-form" action="#">
                            <i class="icon-search"></i>
                            <input type="search" class="form-control" placeholder="Search Here" title="Search here">
                        </form>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator" id="notificationDropdown" href="#"
                            data-bs-toggle="dropdown">
                            <i class="icon-bell"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0"
                            aria-labelledby="notificationDropdown">
                            <a class="dropdown-item py-3 border-bottom">
                                <p class="mb-0 fw-medium float-start">Tienes 2 notificaciones</p>
                                <span class="badge badge-pill badge-primary float-end">Ver todos</span>
                            </a>
                            <a class="dropdown-item preview-item py-3">
                                <div class="preview-thumbnail">
                                    <i class="mdi mdi-lock-outline m-auto text-primary"></i>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject fw-normal text-dark mb-1">Proyecto</h6>
                                    <p class="fw-light small-text mb-0"> prueba </p>
                                </div>
                            </a>

                        </div>
                    </li>


                    <li class="nav-item dropdown  d-lg-block user-dropdown">
                        <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img class="img-xs rounded-circle" src="{{ asset('storage/' . $user->foto) }}"
                                alt="Profile image"> </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                            <div class="dropdown-header text-center">
                                <img class="img-md rounded-circle" height="60" width="60"
                                    src="{{ asset('storage/' . $user->foto) }}" alt="Profile image">
                                <p class="mb-1 mt-3 fw-semibold">{{ $user->nombres }} </p>
                                <p class="fw-light text-muted mb-0">{{ $user->role->nombre }}</p>
                            </div>
                            <a class="dropdown-item"><i
                                    class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Perfil
                            </a>

                            <a href="#" id="logout-link" class="dropdown-item">
                                <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Cerrar sesión
                            </a>

                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-bs-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/inicio') }}">
                            <i class="mdi mdi-grid-large menu-icon"></i>
                            <span class="menu-title">Inicio</span>
                        </a>
                    </li>
                    <li class="nav-item nav-category">Menus</li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false"
                            aria-controls="auth">
                            <i class="menu-icon mdi mdi-account-circle-outline"></i>
                            <span class="menu-title">Sistema</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="auth">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('usuarios') }}">Usuarios</a>
                                </li>

                            </ul>

                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                            aria-controls="ui-basic">
                            <i class="menu-icon mdi mdi-floor-plan"></i>
                            <span class="menu-title">Personas</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="">Responsables</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="">Clientes</a></li>


                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#tesis-basic" aria-expanded="false"
                            aria-controls="tesis-basic">
                            <i class="menu-icon mdi mdi-file-chart-outline"></i>
                            <span class="menu-title">Administracion</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="tesis-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="">Notas de pedido</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="pages/tesis-features/dropdowns.html">pagos</a></li>


                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#conf-basic" aria-expanded="false"
                            aria-controls="conf-basic">
                            <i class="menu-icon mdi mdi-file-chart-outline"></i>
                            <span class="menu-title">Configuraciones</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="conf-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="">Estados
                                        de notas</a></li>

                                <li class="nav-item"> <a class="nav-link"
                                        href="">Medios de pago</a></li>

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="menu-icon mdi mdi-file-document-outline"></i>
                            <span class="menu-title">Documentos</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="main-panel">




                @yield('dashboard')
                @yield('usuarios')
       
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">

                        <span class="float-none float-sm-end d-block mt-1 mt-sm-0 text-center">Area contable Cofimar © 2025</span>
                    </div>
                </footer>
            </div>
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <script src="assets/vendors/js/vendor.bundle.base.js"></script>

    <!-- Plugin JS (antes de dependencias que los usen) -->
    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="assets/vendors/chart.js/chart.umd.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="assets/vendors/dropify/dropify.min.js"></script>
    <script src="assets/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>

    <!-- Color Picker Plugins -->
    <script src="assets/vendors/jquery-asColorPicker/jquery-asColor.min.js"></script>
    <script src="assets/vendors/jquery-asColorPicker/jquery-asGradient.min.js"></script>
    <script src="assets/vendors/jquery-asColorPicker/jquery-asColorPicker.min.js"></script>

    <!-- DataTables -->
    <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>

    <!-- Core Template JS -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>

    <!-- Custom Page Scripts -->
    <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/form-addons.js"></script>
    <script src="assets/js/inputmask.js"></script>
    <script src="assets/js/formpickers.js"></script>

    <script>
        $(document).ready(function() {
            $('#order-listing').DataTable({
                "language": {
                    "paginate": {
                        "previous": "<i class=' icon-arrow-left'></i>", // Flecha izquierda
                        "next": "<i class='icon-arrow-right'></i>", // Flecha derecha
                        "first": "<i class='fas fa-angle-double-left'></i>", // Primer página
                        "last": "<i class='fas fa-angle-double-right'></i>" // Última página
                    },
                    "lengthMenu": "Mostrar _MENU_ ", // Ajuste del texto de la longitud
                    "search": "Buscar:", // Ajuste del texto de búsqueda
                    "zeroRecords": "No se encontraron resultados", // Ajuste cuando no hay resultados
                    "info": " _START_ - _END_ de _TOTAL_ ", // Ajuste de info
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros", // Ajuste cuando no hay registros
                    "infoFiltered": "(filtrado de _MAX_ registros totales)" // Ajuste cuando se filtra
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Asegúrate de que el selector de color está siendo inicializado correctamente
            $('.color-picker').asColorPicker();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#color').asColorPicker({
                mode: 'complex', // Permite opciones avanzadas
                palettes: true, // Muestra una paleta de colores
                sliders: true,  // Habilita los deslizadores (para ajustes de gradiente, etc.)
            });
        });
    </script>
    

    @if (session('toast_message') && session('toast_type'))
        <script>
            (function($) {
                $(document).ready(function() {
                    $.toast({
                        heading: '{{ session('toast_type') === 'success'
                            ? 'Éxito'
                            : (session('toast_type') === 'info'
                                ? 'Información'
                                : (session('toast_type') === 'warning'
                                    ? 'Advertencia'
                                    : 'Error')) }}',
                        text: @json(session('toast_message')),
                        showHideTransition: 'slide',
                        icon: '{{ session('toast_type') }}',
                        loaderBg: '#f96868',
                        position: 'bottom-right'
                    });
                });
            })(jQuery);
        </script>
    @endif



    <script>
        // Función para actualizar el texto del botón con la opción seleccionada
        function seleccionarCarrera(carrera) {
            // Cambiar el texto del botón al nombre de la carrera seleccionada
            document.getElementById('messageDropdown').innerText = carrera;

            // Opcional: Si deseas almacenar el valor en el input oculto
            document.getElementById('carreraInput').value = carrera;
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const logoutLink = document.getElementById('logout-link');
            if (logoutLink) {
                logoutLink.addEventListener('click', (event) => {
                    event.preventDefault();

                    // Crear y enviar un formulario oculto
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('logout') }}";

                    // Agregar el token CSRF
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = "{{ csrf_token() }}";

                    form.appendChild(csrfToken);
                    document.body.appendChild(form);
                    form.submit();
                });
            }
        });
    </script>
    <script>
        (function($) {
            'use strict';
            $('.dropify').dropify({
                messages: {
                    'default': 'Arrastra y suelta el archivo aquí o haz clic',
                    'replace': 'Arrastra y suelta o haz clic para reemplazar',
                    'remove': 'Eliminar',
                    'error': 'Formato no soportado'
                }
            });
        })(jQuery);
    </script>


    {{-- PARA LAS NOTIFICACIONES --}}
    <script>
        (function($) {
            showSuccessToast = function() {
                'use strict';
                resetToastPosition();
                $.toast({
                    heading: 'Success',
                    text: 'Usuario creado correctamente.',
                    showHideTransition: 'slide',
                    icon: 'success',
                    loaderBg: '#f96868',
                    position: 'top-right'
                });
            };

            resetToastPosition = function() {
                $('.jq-toast-wrap').removeClass(
                    'bottom-left bottom-right top-left top-right mid-center');
                $(".jq-toast-wrap").css({
                    "top": "",
                    "left": "",
                    "bottom": "",
                    "right": ""
                });
            };
        })(jQuery);
    </script>

</body>

</html>
