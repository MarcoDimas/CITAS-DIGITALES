@extends('layouts.layout')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma de Citas Digitales</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>


        .titulo {
            color: #61727b;
            border-bottom: 2px solid #61727b;
            padding-bottom: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .titulo h1 {
            font-size: 2em;
            margin: 0;
        }

        .user-info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.2em;
            color: #61727b;
        }

        .description {
            font-size: 1.2em;
            color: #333;
            margin-top: 30px;
            display: none;
            text-align: center;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .toggle-description {
            cursor: pointer;
            color: #61727b;
            text-decoration: none;
            text-align: center;
            margin-top: 20px;
            display: block;
            transition: color 0.3s ease-in-out;
            border: 2px solid #61727b;
            padding: 10px 20px;
            border-radius: 5px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        .toggle-description:hover {
            color: #fff;
            background-color: #61727b;
        }

        .weather-widget {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 30px;
        }

        .weather-details {
            margin-left: 10px;
        }

        .weather-details span {
            display: block;
            font-size: 1.2em;
            color: #333;
        }

        .dropdown-item {
        display: block;
        padding: 10px 15px;
        margin: 5px 0;
        border-radius: 5px;
        text-decoration: none;
        color: #333;
        text-align: center;
        background-color: #f8f9fa;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

        .dropdown-item:hover {
            color: #A50000;
            background-color: #E7CED5; /* Cambia el color de fondo al pasar el ratón */
        }

        .dropdown-item:active {
            background-color: #0056b3; /* Cambia el color de fondo al hacer clic */
        }
    /* Estilo para el botón con ícono */
        .btn-icon {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff; /* Color de fondo del botón */
            color: white; /* Color del texto */
            font-size: 16px; /* Tamaño de fuente */
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-icon:hover {
            background-color: #0056b3; /* Color de fondo al pasar el mouse */
            transform: scale(1.05); /* Efecto de aumento al pasar el mouse */
        }

        .btn-icon:active {
            background-color: #004494; /* Color de fondo al hacer clic */
            transform: scale(0.98); /* Efecto de reducción al hacer clic */
        }

        .btn-icon i {
            margin-right: 8px; /* Espacio entre el ícono y el texto */
            font-size: 20px; /* Tamaño del ícono */
        }

        .main-content{
            display: flex;
            flex-direction: column; /* Alinear los elementos en una columna */
            align-items: center; /* Centrar horizontalmente */
            justify-content: center; /* Centrar verticalmente */
            width: 100%; /* Ajustar al 100% del contenedor */
        }
        .spinner {
            display: none; /* Oculto por defecto */
            width: 40px;
            height: 40px;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-top-color: #000;
            border-radius: 50%;
            animation: spin 1s ease-in-out infinite;
            margin: 10px auto;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <div class="container">
    <div class="main-content">
        <div class="titulo">
            <h1>PLATAFORMA DE CITAS DIGITALES</h1>
        </div>
        @if(session('success'))
            <div id="success-alert" class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div id="error-alert" class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div id="spinner" class="spinner"></div>

        <div class="user-info">
            {{ Auth::user()->role ? (Auth::user()->role->nombre === 'Superadmin' ? 'SUPER ADMINISTRADOR' : (Auth::user()->role->nombre === 'Citas' ? 'USUARIO PARA GENERAR CITAS' : (Auth::user()->role->nombre === 'Administrador' ? 'ADMINISTRADOR' : Auth::user()->role->nombre))) : 'Sin Rol' }}
        </div>

        <div class="description" id="description">
        <p>Esta plataforma innovadora facilita la gestión de citas para trámites y subtrámites de manera digital. Permite a los usuarios solicitar citas, administrarlas y realizar seguimiento de manera eficiente. Además, cuenta con un sistema de roles que garantiza la seguridad y privacidad de la información.</p>
        
        <div class="weather-widget" id="weather-widget">
                <div><canvas id="weather-icon" width="50" height="50"></canvas></div>
                <div class="weather-details">
                    <span id="temperature">--°C</span>
                    <span id="humidity">--%</span>
                </div>
            </div>
        </div>

        @php
            function generarFolioDisponible() {
                do {
                    $folio = rand(100000, 999999); // Generar un número aleatorio de 6 dígitos
                    $exists = \App\Models\Cita::where('folio', $folio)->exists(); // Verificar si ya existe
                } while ($exists);

                return $folio;
            }

            // Generar folio y datos
            $folio = generarFolioDisponible();
            $data = json_encode(['folio' => $folio, 'id_subtramite' => 1, 'id_tramite' => 1]); // Cambia id_subtramite y id_tramite con los valores correctos
            $solicitud = urlencode(base64_encode($data)); // Encriptar usando base64_encode
        @endphp
     
        <a href="#" class="toggle-description" id="toggle-description">Haz clic aquí para ver la descripción</a>
        <a class="toggle-description"  style="width:520px" href="{{ route('calendarios', ['solicitud' => $solicitud]) }}">Registrar Citas</a>
        
        <button id="downloadPdf"  class="toggle-description">
         <i class="fas fa-download"></i> Descargar PDF
        </button>
        </div>
     </div>

    <script>
        $(document).ready(function() {
            var descripcionVisible = false;

            $('#toggle-description').click(function() {
                if (descripcionVisible) {
                    $('.description').slideUp();
                    $(this).text('Haz clic aquí para ver la descripción');
                } else {
                    $('.description').slideDown();
                    $(this).text('Haz clic aquí para ocultar la descripción');
                }
                descripcionVisible = !descripcionVisible;
            });

            // Función para obtener y mostrar el clima
            function fetchWeather() {
                const apiKey = '997dec7f86e9b95a3455fa20b31d64b8'; // Clave API de OpenWeatherMap
                const city = 'Morelia'; // Nombre de la ciudad

                $.ajax({
                    url: `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${apiKey}`,
                    method: 'GET',
                    success: function(data) {
                        updateWeather(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud:', status, error);
                    }
                });
            }

            function updateWeather(data) {
                const temp = data.main.temp;
                const humidity = data.main.humidity;
                const icon = data.weather[0].icon;

                $('#temperature').text(`${temp}°C`);
                $('#humidity').text(`${humidity}%`);

                const iconUrl = `http://openweathermap.org/img/wn/${icon}.png`;
                const img = new Image();
                img.src = iconUrl;
                img.onload = () => {
                    const ctx = document.getElementById('weather-icon').getContext('2d');
                    ctx.clearRect(0, 0, 50, 50);
                    ctx.drawImage(img, 0, 0, 50, 50);
                };
            }

            fetchWeather();
        });
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Verifica si hay una alerta de éxito o error
        var successAlert = document.getElementById('success-alert');
        var errorAlert = document.getElementById('error-alert');

        // Si la alerta de éxito o error está presente, recargar la página después de 3 segundos
        if (successAlert || errorAlert) {
            setTimeout(function () {
                location.reload();
            }, 1500); // 3000 milisegundos = 3 segundos
        }
    });
</script>

    @php
        $generarPdfUrl = route('generarPdf');
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var generarPdfUrl = "{{ $generarPdfUrl }}";
            var downloadButton = document.getElementById('downloadPdf');
            var spinner = document.getElementById('spinner');

            // Definir la función de descarga
            function downloadPdf() {
                console.log("Botón de descarga clickeado"); // Log para verificar si la función se ejecuta una vez
                // Mostrar el spinner
                spinner.style.display = 'block';
                // Deshabilitar el botón para evitar múltiples clics
                downloadButton.disabled = true;
                fetch(generarPdfUrl, {
                    method: 'GET',
                    credentials: 'same-origin'
                }).then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'cita.pdf';
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url); // Revocar el objeto URL después de usarlo
                    // Ocultar el spinner y habilitar el botón nuevamente
                    spinner.style.display = 'none';
                    downloadButton.disabled = false;
                })
                .catch(error => {
                    console.error('Error al descargar el PDF:', error);
                    // Ocultar el spinner y habilitar el botón en caso de error
                    spinner.style.display = 'none';
                    downloadButton.disabled = false;
                });
            }

            // Elimina cualquier listener duplicado
            downloadButton.replaceWith(downloadButton.cloneNode(true));
            downloadButton = document.getElementById('downloadPdf');
            downloadButton.addEventListener('click', downloadPdf);
        });
        
        </script>
</body>
</html>
@endsection
