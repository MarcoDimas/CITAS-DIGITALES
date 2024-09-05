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
        ALTA HORARIOS
    </div>
    <div class="container">
        
        <div class="card my-4">
            <div class="card-header">Alta Horarios</div>
            <div class="card-body">
                <form method="POST" action="{{ route('guardarDatoshoraa') }}">
                    @csrf                                            
                    <div class="row">
                        <div class="col">
                            <label for="">Subtramite:</label>
                            <br>
                            <select  class="form-control"  name="id_subtramite" id="select1" onchange="cargarOpciones()" style="width: 330px;  display: block; background-color: #f9f9f9; text-transform: uppercase;">
                                <option selected>SELECCIONA SUBTRAMITE</option> 
                                @foreach($subtramites as $subtramite)
                                    <option value="{{ $subtramite->id }}">{{ $subtramite->descripcion }}</option>
                                @endforeach 
                            </select>
                           
                        </div>
                        <div class="col">
                            <label for="exampleFormControlTextarea1" class="form-label">Horario de atención (inicia)</label>
                            <input type="time" name="horario_inicio" id="calendario" class="form-control datetimepicker" placeholder="Selecciona Fecha" required style="width: 220px;">
                        </div>
                        <div class="col">
                            <label for="exampleFormControlTextarea1" class="form-label">Horario de atención (fin)</label>
                            <input type="time" name="horario_fin" id="calendario" class="form-control datetimepicker" placeholder="Selecciona Fecha" required style="width: 220px;">
                        </div>                                                                       
                    </div>
                    <div class="row">
                    <div class="col">
                        <div class="col">Duración Trámite (MINUTOS):</label>
                            <input type="text" class="form-control" id="duracion"  name="duracion"  style="width: 350px; text-transform: uppercase;" >
                        </div>
                    </div>
                    <div class="col">
                        <div class="col">Tiempo Holgura (MINUTOS):</label>
                            <input type="text" class="form-control" id="holgura"  name="holgura"  style="width: 350px; text-transform: uppercase;" >
                        </div>
                    </div>
                    <div class="col">
                        <div class="col">Personas por Trámite:</label>
                            <input type="text" class="form-control" id="personas"  name="personas"  style="width: 350px; text-transform: uppercase;" >
                        </div>
                    </div>
                    </div><br><br>
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

               

