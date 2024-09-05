<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de la Cita</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F4F4F4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 600px;
            text-align: center;
        }
        h1 {
            color: #61727b;
            border-bottom: 2px solid #61727b;
            padding-bottom: 20px;
            margin-bottom: 30px;
            font-size: 28px;
        }
        p {
            margin: 8px 0;
            font-size: 16px;
            color: black;
        }
        .atendida {
            color: green;
        }
        .no-atendida {
            color: red;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #61727b;
            font-size: 14px;
            background-color: #F4F4F4;
            padding: 20px;
            border-top: 2px solid #61727b;
        }
        .no-reply {
            margin-top: 10px;
            color: #888;
            font-size: 12px;
        }
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        .logo-container img {
            height: auto;
            margin: 0 33px;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="logo-container">
                <img src="{{ $message->embed(public_path('/imagenes/logoFinanzas.png')) }}" alt="Logo Finanzas" style="width: 150px; height: auto;">
                <img src="{{ $message->embed(public_path('/imagenes/Sello Logo  Principal.png')) }}" alt="Sello" style="width: 80px; height: auto;">
                <img src="{{ $message->embed(public_path('/imagenes/200 AÑOS[1].png')) }}" alt="Logo" style="width: 150px; height: auto;">
        </div>
        <h1>ESTADO DE LA CITA</h1>
        <p>Nombre: {{ $cita->nombre }} {{ $cita->ape_paterno }} {{ $cita->ape_materno }}</p>
        <p>Fecha de la Cita: {{ $cita->fecha }}</p>
        <p>Hora de la Cita: {{ $cita->horario }}</p>
        <!-- Aplica las clases atendida o no-atendida según el estado de la cita -->
        <p>Estado de la Cita: <span class="{{ $estadoAnterior ? 'atendida' : 'no-atendida' }}">{{ $estadoAnterior ? 'Atendida' : 'No atendida' }}</span></p>
        <p>La cita fue {{ $estadoAnterior ? 'atendida' : 'no atendida' }} el día {{ $fechaActual }}.</p>
        <div class="footer">
            <p class="no-reply">Favor de no responder a este mensaje, es un envío automático.</p>
        </div>
    </div>
</body>
</html>
