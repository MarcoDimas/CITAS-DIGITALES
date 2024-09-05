<!DOCTYPE html>
<html>

<head>
    <title>Confirmación de Cita</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F4F4F4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 600px;
            text-align: center;
            position: relative;
        }

        h1 {
            color: #61727b;
            border-bottom: 2px solid #61727b;
            padding-bottom: 20px;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .important-info {
            margin-bottom: 30px;
            text-align: center;
        }

        .important-info p {
            margin: 8px 0;
            font-size: 16px;
            color: black;
        }

        .details {
            border-top: 1px solid #61727b;
            padding-top: 20px;
            text-align: center;
        }

        .details h2 {
            font-size: 22px;
            color: #61727b;
            margin-bottom: 15px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        ul li {
            margin-bottom: 10px;
            font-size: 16px;
            color: black;
        }

        ul li strong {
            font-weight: bold;
            color: black;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .logo-container img {
            height: auto;
            margin: 0 25px;
        }

        .footer {
            text-align: center;
            color: #888;
            font-size: 14px;
            padding: 15px 0;
            background-color: #f8f8f8;
            border-top: 2px solid #ddd;
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img class="logo-header" src="{{ url('/imagenes/logoFinanzas.png') }}" alt="Logo Finanzas"
                style="width: 160px; height: auto;">
            <img class="logo-headerG" src="{{ url('/imagenes/Sello Logo  Principal.png') }}" alt="Sello Principal"
                style="width: 82px; height: auto;">
            <img class="logo-header" src="{{ url('/imagenes/200 AÑOS[1].png') }}" alt="200 Años"
                style="width: 160px; height: auto;">
        </div>
        <h1>Confirmación de Cita</h1>   
        <div class="important-info">
            <p><strong>Nombre:</strong> {{ $datos['cita']->nombre }} {{ $datos['cita']->ape_paterno }} {{ $datos['cita']->ape_materno }}</p>
            <p><strong>Trámite:</strong> {{ $datos['tramite_descripcion'] }}</p>
            <p><strong>Subtrámite:</strong> {{ $datos['subtramite_descripcion'] }}</p>
        </div>
        <div class="details">
            <h2>Detalles de la Cita:</h2>
            <ul>
                <li><strong>RFC:</strong> {{ $datos['cita']->rfc }}</li>
                <li><strong>Fecha de la Cita:</strong> {{ $datos['cita']->fecha }}</li>
                <li><strong>Horario de la Cita:</strong> {{ $datos['cita']->horario }}</li>
            </ul>
        </div>
        <div class="details">
            <h2>Requisitos de la Cita:</h2>
            <ul>
                @if(!empty($datos['requisitos']) && is_array($datos['requisitos']))
                    @foreach($datos['requisitos'] as $requisito)
                        <li>{{ $requisito }}</li> <!-- Asumiendo que 'requisitos' es un array de strings -->
                    @endforeach
                @elseif(is_string($datos['requisitos']))
                    <li>{{ $datos['requisitos'] }}</li> <!-- Si 'requisitos' es solo un string -->
                @else
                    <li>{{ $datos['subtramite_requisitos'] }}.</li>
                @endif
            </ul>
        </div>




        <div class="details">
            <ul>
                <li><strong>Nota importante:</strong> El día que asista a su cita recuerde presentar físicamente en
                    ORIGINAL y COPIA los documentos que guardó en esta solicitud.</li>
         
                </ul>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Todos los derechos reservados</p>
        </div>
    </div>
</body>

</html>
