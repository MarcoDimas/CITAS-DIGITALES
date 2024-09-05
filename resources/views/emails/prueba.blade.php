<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de Cita</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f4f8;
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
            margin: 0 33px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #61727b;
            font-size: 14px;
            background-color: #DCDCDC;
            padding: 20px;
            border-top: 2px solid #61727b;
        }
        .no-reply {
            margin-top: 10px;
            color: #888;
            font-size: 12px;
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
        <h1>Confirmación de Cita</h1>
        <div class="important-info">
            <p><strong>Nombre:</strong> {{ $datos['nombre'] }} {{ $datos['ape_paterno'] }} {{ $datos['ape_materno'] }}</p>
            <p><strong>Trámite:</strong> {{ $datos['tramite_descripcion'] }}</p>
            <p><strong>Subtramite:</strong> {{ $datos['subtramite_descripcion'] }}</p>
        </div>
        <div class="details">
            <h2>Detalles de la Cita:</h2>
            <ul>
                <li><strong>RFC:</strong> {{ $datos['rfc'] }}</li>
                <li><strong>Fecha de la Cita:</strong> {{ $datos['fecha'] }}</li>
                <li><strong>Horario de la Cita:</strong> {{ $datos['horario'] }}</li>
            </ul>
        </div>
        <div class="details">
            <h2>Requisitos de la Cita:</h2>
            <ul>
                <li>{{ $requisitos }}</li>
            </ul>
        </div>
        <div class="details">
            <ul>
                <li><strong>Nota importante:</strong>  El día que asista a su cita recuerde presentar físicamente en ORIGINAL y COPIA los documentos que guardó en esta solicitud.</li>
              
            </ul>
        </div>
        <br>
        <br>
        <br>
        <div class="footer">
        <p class="no-reply">Favor de no responder a este mensaje, es un envío automático.</p>
    </div>
    </div>
</body>
</html>












