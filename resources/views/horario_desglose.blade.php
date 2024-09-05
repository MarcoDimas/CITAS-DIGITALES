@extends('layouts.layout')

@section('content')
<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario</title>
    <link rel="stylesheet" href="/node_modules/@fullcalendar/core/main.css">
    <link rel="stylesheet" href="/node_modules/@fullcalendar/daygrid/main.css">
</head>

<div class="container">
    <div class="ms-5 titulo borderBottom--Guinda mt-2 text-big text-morado text-semibold Gibson Medium">
        Desglosar Horario
    </div>
    <div class="container">
        
        <div class="card my-4">
            <div class="card-header">Registrar Desglose del Horario </div>
            <div class="card-body">
                <form method="POST" action="{{ route('guardarDatohorarios') }}">
                    @csrf
                      <div class="row">
                                                
                        <div class="col">
                            <label for="id_dependencia" class="col-form-label"><i class="bi-sm  bi-clipboard-fill"></i> Horarios:</label>
                            <br>
                        <select  class="form-control"  name="id_fecha" id="select1" onchange="cargarOpciones()" style="width: 330px;  display: block; background-color: #f9f9f9;">
                          <option selected>SELECCIONA HORARIO</option> 
                          @foreach($fechas as $fecha)
                              <option value="{{ $fecha->id }}">{{ $fecha->horario_inicio }} -- {{ $fecha->horario_fin }}</option>
                          @endforeach 
                      </select>
                        </div>
                        <div class="col">
                            <label for="exampleFormControlTextarea1" class="form-label"><i class="bi-sm  bi-clipboard-fill"></i> Hora Inicia</label>
                            <textarea class="form-control" id="horario_inicio" name="horario_inicio" rows="1"></textarea>
                        </div>
                      </div>
                      <div class="row">                                                
                        <div class="col">
                            <label for="exampleFormControlTextarea1" class="form-label"><i class="bi-sm  bi-clipboard-fill"></i> Hora Fin</label>
                            <textarea class="form-control" id="horario_fin" name="horario_fin" rows="1"></textarea>
                        </div>
                        <div class="col">
                            <label for="exampleFormControlTextarea1" class="form-label"><i class="bi-sm  bi-clipboard-fill"></i> Duracion</label>
                            <textarea class="form-control" id="duracion" name="duracion" rows="1"></textarea>
                        </div>
                      </div>
                        
                    <br><br>
                    <div class="text-center">
                      <button  type="submit" class="btn btn-secondary">Guardar</button>
                  </div>        
              </form>
              
            </div>
        </div>
    </div>
</div>


        <!-- En la vista -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

@endsection
<script src="/node_modules/@fullcalendar/core/main.js"></script>
    <script src="/node_modules/@fullcalendar/daygrid/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendario');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['dayGrid'],
                selectable: true,
                select: function (info) {
                    // Aquí puedes manejar la selección de días
                    console.log('Fecha seleccionada:', info.startStr, ' - ', info.endStr);
                },
            });

            calendar.render();
        });
    </script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Evento cuando cambia el valor del primer select
        $('#select1').change(function () {
            var selectedValue = $(this).val();

            // Hacer una solicitud AJAX para obtener datos filtrados
            $.ajax({
                url: 'http://localhost:80/citas-en-linea-mvc/public/obtenerDatosfilr', // Reemplaza con la ruta de tu controlador
                type: 'GET',
                data: {selectedValue: selectedValue},
                success: function (data) {
                    // Limpiar el segundo select
                    $('#select2').empty();

                    // Llenar el segundo select con los datos filtrados
                    $.each(data, function (key, value) {
                        $('#select2').append('<option value="' + value.id_subtramite + '">' + value.desc_subtramite + '</option>');
                    });
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    });
</script>
               

