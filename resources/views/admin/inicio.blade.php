@extends('recursos.barra')

@section('dashboard')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview"
                                    role="tab" aria-controls="overview" aria-selected="true">Inicio</a>
                            </li>

                        </ul>
                        <div>
                            <div class="btn-wrapper">
                                <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i>
                                    Soporte</a>
                                <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Recuperar</a>
                                {{-- color= dribbble --}}
                                <a href="#" class="btn btn-primary text-white me-0"><i class="icon-download"></i>
                                    Buckup</a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content tab-content-basic">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="statistics-details d-flex align-items-center justify-content-between">
                                        <div>
                                            <p class="statistics-title">Estudiantes</p>
                                            <h3 class="rate-percentage">32 <i
                                                    class="dropdown-item-icon mdi mdi-account-group-outline text-primary me-2"></i>
                                            </h3>

                                        </div>
                                        <div>
                                            <p class="statistics-title">Cursos</p>
                                            <h3 class="rate-percentage">16 <i
                                                    class="dropdown-item-icon mdi mdi-book-outline text-primary me-2"></i>
                                            </h3>

                                        </div>
                                        <div>
                                            <p class="statistics-title">Pagos</p>
                                            <h3 class="rate-percentage">18 <i
                                                    class="dropdown-item-icon mdi mdi-credit-card-outline text-primary me-2"></i>
                                            </h3>

                                        </div>
                                        <div class="d-none d-md-block">
                                            <p class="statistics-title">Registros</p>
                                            <h3 class="rate-percentage">7 <i
                                                    class="dropdown-item-icon mdi mdi-file-chart-check-outline text-primary me-2"></i>
                                            </h3>

                                        </div>
                                        <div class="d-none d-md-block">
                                            <p class="statistics-title">Deudas</p>
                                            <h3 class="rate-percentage">20 <i
                                                    class="dropdown-item-icon mdi mdi-file-clock-outline text-primary me-2"></i>
                                            </h3>

                                        </div>
                                        <div class="d-none d-md-block">
                                            <p class="statistics-title">Cancelados</p>
                                            <h3 class="rate-percentage">2 <i
                                                    class="dropdown-item-icon mdi mdi-file-remove-outline text-primary me-2"></i>
                                            </h3>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                            <div class="card card-rounded">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h4 class="modern-user-intro">
                                                                Hola {{ Str::title(Str::lower($user->nombres)) }}
                                                            </h4>
                                                            <h6 class="mdern-welcome-text">
                                                                {{ Str::title(Str::lower($user->role->nombre)) }}
                                                            </h6>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <a href="#">
                                                                <div class="bg-opacity-primary mb-2 mb-lg-0">
                                                                    <i class="mdi mdi-credit-card"></i>
                                                                    <p>Pagos</p>
                                                                    <div class="text-end">
                                                                        <i class="mdi mdi-arrow-right"></i>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <a href="#">
                                                                <div class="bg-opacity-success mb-2 mb-lg-0">
                                                                    <i class="mdi mdi-book"></i>
                                                                    <p>Cursos</p>
                                                                    <div class="text-end">
                                                                        <i class="mdi mdi-arrow-right"></i>
                                                                    </div>
                                                                </div>
                                                            </a>

                                                        </div>
                                                        <div class="col-sm-3">
                                                            <a href="#">
                                                                <div class="bg-opacity-info mb-2 mb-lg-0">
                                                                    <i class="mdi mdi-account-check"></i>
                                                                    <p>Estudiantes</p>
                                                                    <div class="text-end">
                                                                        <i class="mdi mdi-arrow-right"></i>
                                                                    </div>
                                                                </div>
                                                            </a>

                                                        </div>
                                                        <div class="col-sm-3">
                                                            <a href="#">
                                                                <div class="bg-opacity-danger mb-2 mb-lg-0">
                                                                    <i class="mdi mdi-cellphone"></i>
                                                                    <p>Sistema</p>
                                                                    <div class="text-end">
                                                                        <i class="mdi mdi-arrow-right"></i>
                                                                    </div>
                                                                </div>
                                                            </a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-8 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                            <div class="card card-rounded">
                                                <div class="card-body">
                                                    <div class="d-sm-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h4 class="card-title card-title-dash">
                                                                Seguimientos </h4>
                                                            <h5 class="card-subtitle card-subtitle-dash">
                                                                Tesis aprobados en este año</h5>
                                                        </div>
                                                        <div id="performanceLine-legend"></div>
                                                    </div>
                                                    <div class="chartjs-wrapper mt-4">
                                                        <canvas id="performanceLine" width=""></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-lg-4 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                                            <div class="card card-rounded">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-3">
                                                                <div
                                                                    class="d-sm-flex justify-content-between align-items-start">
                                                                    <div>
                                                                        <h4 class="card-title card-title-dash">
                                                                            Notas</h4>
                                                                        <h5 class="card-subtitle card-subtitle-dash">
                                                                            Notas de pedidos</h5>
                                                                    </div>
                                                                    <div id="performanceLine-legend"></div>
                                                                </div>
                                                                <div>
                                                                    <div class="dropdown">

                                                                        <div class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton3">
                                                                            <h6 class="dropdown-header">
                                                                                week Wise</h6>
                                                                            <a class="dropdown-item" href="#">Year
                                                                                Wise</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mt-3">
                                                                <canvas id="leaveReport"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            {{-- <div class="row">
                                <div class="col-lg-8 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                            <div class="card card-rounded">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h4 class="modern-user-intro">Hello John Doe,</h4>
                                                            <h6 class="mdern-welcome-text">Welcome back</h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <div class="bg-opacity-primary mb-2 mb-lg-0">
                                                                <i class="mdi mdi-credit-card"></i>
                                                                <p>Transfer via card number</p>
                                                                <div class="text-end">
                                                                    <i class="mdi mdi-arrow-right"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="bg-opacity-success mb-2 mb-lg-0">
                                                                <i class="mdi mdi-home"></i>
                                                                <p>Transfer to another bank</p>
                                                                <div class="text-end">
                                                                    <i class="mdi mdi-arrow-right"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="bg-opacity-info mb-2 mb-lg-0">
                                                                <i class="mdi mdi-account-check"></i>
                                                                <p>Transfer to the same bank</p>
                                                                <div class="text-end">
                                                                    <i class="mdi mdi-arrow-right"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="bg-opacity-danger mb-2 mb-lg-0">
                                                                <i class="mdi mdi-cellphone"></i>
                                                                <p>Transfer using UPI number</p>
                                                                <div class="text-end">
                                                                    <i class="mdi mdi-arrow-right"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-lg-8 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                                            <div class="card card-rounded">
                                                <div class="card-body card-rounded">
                                                    <h4 class="card-title  card-title-dash">Notas observadas
                                                    </h4>
                                                    <div class="list align-items-center border-bottom py-2">
                                                        <div class="wrapper w-100">
                                                            <p class="mb-2 fw-medium"> notas tal
                                                            </p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="mdi mdi-calendar text-muted me-1"></i>
                                                                    <p class="mb-0 text-small text-muted">
                                                                        Sep 14, 2025</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="list align-items-center border-bottom py-2">
                                                        <div class="wrapper w-100">
                                                            <p class="mb-2 fw-medium"> Other Events </p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="mdi mdi-calendar text-muted me-1"></i>
                                                                    <p class="mb-0 text-small text-muted">
                                                                        Mar 14, 2019</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="list align-items-center border-bottom py-2">
                                                        <div class="wrapper w-100">
                                                            <p class="mb-2 fw-medium"> Quarterly Report
                                                            </p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="mdi mdi-calendar text-muted me-1"></i>
                                                                    <p class="mb-0 text-small text-muted">
                                                                        Mar 14, 2019</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="list align-items-center border-bottom py-2">
                                                        <div class="wrapper w-100">
                                                            <p class="mb-2 fw-medium"> Change in Directors
                                                            </p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="mdi mdi-calendar text-muted me-1"></i>
                                                                    <p class="mb-0 text-small text-muted">
                                                                        Mar 14, 2019</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="list align-items-center pt-3">
                                                        <div class="wrapper w-100">
                                                            <p class="mb-0">
                                                                <a href="#" class="fw-bold text-primary">Show
                                                                    all
                                                                    <i class="mdi mdi-arrow-right ms-2"></i></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
