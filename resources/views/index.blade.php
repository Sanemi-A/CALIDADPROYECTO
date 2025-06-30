<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <title>Cinfo</title>
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
                                            value="{{ old('email', $email ?? '') }}" required>
                                    </div>

                                    <!-- Campo para la contraseña -->
                                    <div class="mb-2 form-group form-required">
                                        <label class="form-label">Contraseña</label>
                                        <input type="password" id="password" class="form-control" name="password"
                                            required autocomplete="off">
                                    </div>

                                    <!-- Checkbox "Recordarme" -->
                                    <div class="mb-2">
                                        <label class="form-check">
                                            <input type="checkbox" class="form-check-input" name="remember"
                                                {{ old('remember', $remember) ? 'checked' : '' }}>
                                            <span class="form-check-label">Recordarme en este dispositivo</span>
                                        </label>
                                    </div>

                                    <!-- Botón de enviar -->
                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-blue w-100">Ingresar</button>
                                    </div>
                                    <div id="bloqueo-mensaje"
                                        class="alert alert-warning py-1 px-2 mt-3 d-none text-center small rounded-3 shadow-sm border">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        <span>Demasiados intentos fallidos. Intenta de nuevo en <br><strong
                                                id="tiempo-restante">60</strong> segundos.</span>
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

    {{-- <script>
        const maxIntentos = 10;
        const tiempoBloqueo = 60;
        const form = document.querySelector('form');
        const mensajeBloqueo = document.getElementById('bloqueo-mensaje');
        const tiempoRestante = document.getElementById('tiempo-restante');

        const claveIntentos = 'login_intentos';
        const claveBloqueo = 'login_bloqueado_hasta';

        const ahora = Math.floor(Date.now() / 1000);
        const bloqueadoHasta = localStorage.getItem(claveBloqueo);

        // Si aún está bloqueado
        if (bloqueadoHasta && ahora < bloqueadoHasta) {
            bloquearFormulario(bloqueadoHasta - ahora);
        }

        form.addEventListener('submit', (e) => {
            // Si está bloqueado, no enviar
            if (localStorage.getItem(claveBloqueo) && ahora < localStorage.getItem(claveBloqueo)) {
                e.preventDefault();
                return;
            }

            // Simula fallo (esto es solo para probar; en real se haría desde Laravel)
            let intentos = parseInt(localStorage.getItem(claveIntentos)) || 0;
            intentos++;
            localStorage.setItem(claveIntentos, intentos);

            if (intentos >= maxIntentos) {
                const desbloqueo = ahora + tiempoBloqueo;
                localStorage.setItem(claveBloqueo, desbloqueo);
                bloquearFormulario(tiempoBloqueo);
                e.preventDefault();
            }
        });

        function bloquearFormulario(segundos) {
            form.querySelector('button[type="submit"]').disabled = true;
            mensajeBloqueo.classList.remove('d-none');

            const intervalo = setInterval(() => {
                segundos--;
                tiempoRestante.textContent = segundos;

                if (segundos <= 0) {
                    clearInterval(intervalo);
                    mensajeBloqueo.classList.add('d-none');
                    form.querySelector('button[type="submit"]').disabled = false;
                    localStorage.removeItem(claveIntentos);
                    localStorage.removeItem(claveBloqueo);
                }
            }, 1000);
        }
    </script> --}}



</body>

</html>
