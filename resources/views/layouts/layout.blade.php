<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Styles -->
    <link href="{{ asset('css/Stylos.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    <!-- Meta tag para el token CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>

</head>
<nav class="navbar justify-content-between shadow-sm bg-white boderBottom--Rosa position-static">
    <a class="navbar-brand" href="#">
        <img class="logo-header" src="{{ asset('imagenes/logoFinanzas.png') }}" alt="">
    </a>
    <a class="navbar-brand" href="#">
        <img class="logo-headerG" src="{{ asset('imagenes/Sello Logo  Principal.png') }}" alt="">
    </a>
    <a class="navbar-brand" href="#">
        <img class="logo-header" src="{{ asset('imagenes/200 AÑOS[1].png') }}" alt="">
    </a>

</nav>

@if (auth()->check())
    <div class="container-fluid vh-100 d-flex">
        <div class="menuLateral pb-3 px-3">
            <div class="menu-header mt-4">
            <img height="90px" src="{{ asset('asset/veda/usua.png') }}" alt="">
            </div>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('menuPrincipal') }}"><i
                            class="bi bi-house-door me-2"></i>Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    
                </li>
                <li class="nav-item dropdown">
                   
                @if(auth()->user()->id_roles == 1 || auth()->user()->id_roles == 2)

                <a class="nav-link dropdown-toggle" href="#" role="button" onclick="toggleDropdownss()">
                    <i class="bi bi-person-bounding-box me-2"></i>Usuarios
                </a>
                <ul class="dropdown-menu" id="sssubMenu" style="display: none;">
                    <li><a class="dropdown-item" href="{{ route('usuarios3') }}">Alta Usuarios</a></li>
                    <li><a class="dropdown-item" href="{{ route('vusuario') }}">Ver Usuarios</a></li>
                </ul>
                

                <a class="nav-link dropdown-toggle" href="#" role="button" onclick="toggleDropdown()">
                        <i class="bi bi-book me-2"></i> {{ Auth::user()->role ? (Auth::user()->role->nombre === 'Superadmin' ? 'SUPER ADMINISTRADOR' : (Auth::user()->role->nombre === 'Administrador' ? 'ADMINISTRADOR' : Auth::user()->role->nombre)) : 'Sin Rol' }}

                    </a>

                 @endif  
                 <ul class="dropdown-menu" id="subMenu" style="display: none; width: 120px; padding: 0; margin: 0; font-size: 12px; background-color: #ffffff; border: 1px solid #ccc; border-radius: 4px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
                    @if(auth()->user()->id_roles == 1)
                        <li><a class="dropdown-item" href="{{ route('dependencias') }}" style="display: block; padding: 6px 10px; text-decoration: none; color: #333;">Alta Dependencia</a></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ route('area3') }}" style="display: block; padding: 6px 10px; text-decoration: none; color: #333;">Alta Dirección</a></li>
                    <li><a class="dropdown-item" href="{{ route('tramites3') }}" style="display: block; padding: 6px 10px; text-decoration: none; color: #333;">Alta Trámite</a></li>
                    <li><a class="dropdown-item" href="{{ route('subtramite3') }}" style="display: block; padding: 6px 10px; text-decoration: none; color: #333;">Alta Subtramite</a></li>
                    <li><a class="dropdown-item" href="{{ route('fechas3') }}" style="display: block; padding: 6px 10px; text-decoration: none; color: #333;">Alta Fecha</a></li>
                </ul>

                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" onclick="otrotoggleDropdown()">
                        <i class="bi bi-journal-check me-2"></i>Citas
                    </a>
                    <ul class="dropdown-menu" id="otrosubMenu" style="display: none;">
                        <li>
                            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"></script>

                            <script>
                                $(document).ready(function() {
                                    // Inicializar DataTables y definir columnas para ordenar
                                    var table = new DataTable("#tablaUsuarios", {
                                        language: {
                                            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                                        }
                                    });
                                });
                            </script>
                            <a class="dropdown-item" href="{{ route('users') }}">Ver Citas</a>
                        </li>
                    </ul>
                </li>
                
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <!-- Otros elementos de la barra de navegación -->
                </li>
                <li class="nav-item mt-auto"> <!-- Aquí se añade la clase mt-auto -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link btn btn-outline-danger"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</button>
                    </form>
                </li>
            </ul>
        </div>
        <div class="container-fluid pt-5 content">
            @yield('content')
        </div>
    </div>
@endif

<div class="container-fluid pt-5 content">
    @yield('content')

    <div id="loader-overlay">
        <div id="loader">
            <img src="{{ asset('imagenes/Logo3.gif') }}" alt="Loader" style="width: 340px; height: 270px;" class="loaderGif">
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script>
    function toggleDropdown() {
        var subMenu = document.getElementById("subMenu");
        if (subMenu.style.display === "none") {
            subMenu.style.display = "block";
        } else {
            subMenu.style.display = "none";
        }
    }

    function toggleDropdownss() {
        var subMenu = document.getElementById("sssubMenu");
        if (subMenu.style.display === "none") {
            subMenu.style.display = "block";
        } else {
            subMenu.style.display = "none";
        }
    }
    function otrotoggleDropdown() {
        var otrosubMenu = document.getElementById("otrosubMenu");
        if (otrosubMenu.style.display === "none") {
            otrosubMenu.style.display = "block";
        } else {
            otrosubMenu.style.display = "none";
        }
    }

    function otrotoggleDropdownss() {
        var otrosubMenu = document.getElementById("otrosubMenus");
        if (otrosubMenu.style.display === "none") {
            otrosubMenu.style.display = "block";
        } else {
            otrosubMenu.style.display = "none";
        }
    }

    function showLoader() {
        document.getElementById('loader-overlay').style.display = 'block';
        const tiempoDeEjecucion = 3000;
        setTimeout(function() {
            document.getElementById('loader-overlay').style.display = 'none';
        }, tiempoDeEjecucion);
    }
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                showLoader();
                this.submit();
            });
        });
    });
</script>
</body>

</html>
