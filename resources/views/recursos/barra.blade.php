<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'inicio | Cindo')</title>

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

    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-toast-plugin/jquery.toast.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/select.dataTables.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="shortcut icon" href="assets/images/logo.png" />
    <style>
        .pagination {
            font-size: 0.85rem;
            gap: 4px;
        }

        .pagination .page-item .page-link {
            border-radius: 0.5rem;
            padding: 0.35rem 0.6rem;
            border: 1px solid #dee2e6;
            color: #495057;
            transition: background-color 0.2s ease-in-out;
        }

        .clear-search {
            background: transparent;
            border: none;
            padding: 0 8px;
            font-size: 1.2rem;
            color: #888;
            cursor: pointer;
            line-height: 1;
            transition: color 0.2s ease;
        }

        .clear-search:hover {
            color: #444;
        }

        .pagination .page-item.active .page-link {
            background-color: #1F3BB3;
            /* o tu color primario */
            color: white;
            border-color: #1F3BB3;
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.5;
        }

        .pagination .page-link:hover {
            background-color: #e9ecef;
            text-decoration: none;
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
                                {{ $saludo }}, <span class="text-black fw-bold" id="user-name">
                                    {{ Str::title(Str::lower($user->nombres . ' ' . $user->apellido_paterno . ' ' . $user->apellido_materno)) }}
                                </span>

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
                                    <h6 class="preview-subject fw-normal text-dark mb-1">2 estudiantes deben etc</h6>
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

                    {{-- INICIO --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/inicio') }}">
                            <i class="mdi mdi-home menu-icon"></i>
                            <span class="menu-title">Inicio</span>
                        </a>
                    </li>

                    {{-- SISTEMA --}}
                    <li class="nav-item nav-category">Gestión del sistema</li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sistema" aria-expanded="false"
                            aria-controls="sistema">
                            <i class="menu-icon mdi mdi-account-cog-outline"></i>
                            <span class="menu-title">Usuarios & Accesos</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="sistema">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('usuarios') }}">Usuarios</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('personas') }}">Datos
                                        personales</a></li>
                                <li class="nav-item"><a class="nav-link" href="">Roles</a></li>
                            </ul>
                        </div>
                    </li>

                    {{-- ESTUDIANTES --}}
                    <li class="nav-item nav-category">Gestión académica</li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#estudiantes" aria-expanded="false"
                            aria-controls="estudiantes">
                            <i class="menu-icon mdi mdi-school-outline"></i>
                            <span class="menu-title">Estudiantes</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="estudiantes">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('estudiantes') }}">Lista</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="">Matrículas</a></li>
                                <li class="nav-item"><a class="nav-link" href="">Mensualidades</a></li>
                            </ul>
                        </div>
                    </li>

                    {{-- DOCENTES --}}
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#docentes" aria-expanded="false"
                            aria-controls="docentes">
                            <i class="menu-icon mdi mdi-human-male-board"></i>
                            <span class="menu-title">Docentes</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="docentes">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="">Lista</a></li>
                                <li class="nav-item"><a class="nav-link" href="">Contratos</a></li>
                            </ul>
                        </div>
                    </li>

                    {{-- CURSOS --}}
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#cursos" aria-expanded="false"
                            aria-controls="cursos">
                            <i class="menu-icon mdi mdi-book-open-variant"></i>
                            <span class="menu-title">Cursos</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="cursos">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="">Lista de
                                        cursos</a></li>
                                <li class="nav-item"><a class="nav-link" href="">Horarios</a></li>
                            </ul>
                        </div>
                    </li>

                    {{-- CONFIGURACIÓN --}}
                    <li class="nav-item nav-category">Configuración</li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#configuracion" aria-expanded="false"
                            aria-controls="configuracion">
                            <i class="menu-icon mdi mdi-cog-outline"></i>
                            <span class="menu-title">Parámetros</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="configuracion">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="">Carreras</a></li>
                                <li class="nav-item"><a class="nav-link" href="">Niveles</a></li>
                                <li class="nav-item"><a class="nav-link" href="">Programas</a></li>
                            </ul>
                        </div>
                    </li>

                    {{-- CERTIFICADOS / DOCUMENTOS --}}
                    <li class="nav-item nav-category">Otros</li>
                    <li class="nav-item">
                        <a class="nav-link" href="">
                            <i class="menu-icon mdi mdi-certificate-outline"></i>
                            <span class="menu-title">Certificados</span>
                        </a>
                    </li>

                </ul>
            </nav>


            <div class="main-panel">




                @yield('dashboard')
                @yield('usuarios')
                @yield('personas')
                @yield('estudiantes_lista')

                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">

                        <span class="float-none float-sm-end d-block mt-1 mt-sm-0 text-center">
                            Centro de Informática UNAMAD © {{ date('Y') }}
                        </span>

                    </div>
                </footer>
            </div>
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-toast-plugin/jquery.toast.min.js') }}"></script>

    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/tooltips.js') }}"></script>
    <script src="{{ asset('assets/js/popover.js') }}"></script>

    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/llamartablas.js') }}"></script>


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
                    'default': 'Arrastra un archivo o haz clic aquí',
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
