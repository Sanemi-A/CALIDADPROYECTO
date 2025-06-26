<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <title>Coficop</title>
    <link rel="manifest" href="/manifest.json">
    <!-- Styles -->
    <link href="assets/login/estiilo1.css" rel="stylesheet" />
    <link href="assets/login/estiilo2.css" rel="stylesheet" />
    <link href="assets/login/estiilo3.css" rel="stylesheet" />

</head>

<body class="antialiased border-top-wide border-pink d-flex flex-column">
    <div class="page page-center" style="margin-top: -2px;">
        <div class="container py-4">
            <div class="row">
                <div class="col-12 text-center mb-3">
                    <a href="#">
                        <img src="{{ asset('storage/sistema/CEINFO_LOGO.png') }}" height="60" alt="">
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center mb-4">



                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6 p-3">


                    <div class="flex-grow-1 h-100 d-flex flex-column justify-content-center">
                        <div class="container-tight py-4">
                            <form class="card card-md" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div id="form_login" class="card-body">
                                    <h2 class="card-title text-center mb-2">Ingrese sus credenciales</h2>

                                    <!-- Mostrar mensaje de error general -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <strong>Credenciales incorrectas. Por favor, inténtalo nuevamente.</strong>
                                        </div>
                                    @endif

                                    <!-- Campo para el correo electrónico -->
                                    <div class="mb-3 form-group form-required">
                                        <label class="form-label">Correo electrónico</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email', request()->cookie('email')) }}" required>
                                    </div>

                                    <!-- Campo para la contraseña -->
                                    <div class="mb-2 form-group form-required">
                                        <label class="form-label">Contraseña</label>
                                        <input type="password" id="password" class="form-control" name="password"
                                            value="{{ request()->cookie('password') }}" required autocomplete="off">
                                    </div>

                                    <!-- Checkbox "Recordarme" -->  
                                    <div class="mb-2">
                                        <label class="form-check">
                                            <input type="checkbox" class="form-check-input" name="remember"
                                                {{ request()->cookie('remember') ? 'checked' : '' }}>
                                            <span class="form-check-label">Recordarme en este dispositivo</span>
                                        </label>
                                    </div>

                                    <!-- Botón de enviar -->
                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-blue w-100">Ingresar</button>
                                    </div>
                                </div>
                            </form>



                            <div class="text-center text-muted mt-3">
                                ¿Tienes problemas para ingresar? <a href="#" tabindex="-1" target="_blank">Te
                                    ayudamos</a>
                            </div>

                        </div>
                    </div>
                </div>
                

            </div>
        </div>
    </div>


    <div id="mensaje_container"></div>
    <!-- MODAL -->
    <!-- Tabler Core -->


</body>

</html>
