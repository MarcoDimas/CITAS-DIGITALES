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

<div class="container" style="margin-top: -45px;">
        <!--div class="ms-5 titulo borderBottom--Guinda mt-2 text-big text-morado text-semibold Gibson Medium">-->
        <div class="ms-5 titulo   mt-2 text-big text-semibold Gibson Medium " style="color:#61727b; border-bottom: 2px solid #61727b;">
              ALTA DÍAS Y HORARIOS        </div>

              @if(session('success'))
            <div class="alert alert-success"  style="margin-top: 4px;">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger"  style="margin-top: -19px;">{{ session('error') }}</div>
        @endif

        @if (session('reload'))
        <script>
            setTimeout(function() {
                location.reload();
            }, 1700); // Espera 2 segundos antes de recargar
        </script>
    @endif

        <div class="container" style="margin-top: -15px;">

        
        <div class="card my-4">
            <div class="card-header">Alta Días y horarios</div>
            <div class="card-body">
                <form method="POST" action="{{ route('guardarDatosfech') }}">
                    @csrf                                            
                    <div class="row">
                        <div class="col">
                            <label for="">Subtramite:</label>
                            <br>
                            <select class="form-control" name="id_subtramite" id="select1" onchange="cargarOpciones()" style="width: 330px; display: block; background-color: #f9f9f9; text-transform: uppercase;">
                                    <option disabled>SELECCIONA SUBTRAMITE</option> 
                                                @foreach($subtramites as $subtramite)
                                   <option value="{{ $subtramite->id }}">{{ $subtramite->descripcion }}</option>
                                               @endforeach 
                            </select>

                        </div>
                        <div class="col">
                            <label for="exampleFormControlTextarea1" class="form-label">Días de atención (inicia)</label>
                            <input type="date" name="fecha_inicio" id="calendario" class="form-control datetimepicker" placeholder="Selecciona Fecha" required style="width: 220px;">
                        </div>
                        <div class="col">
                            <label for="exampleFormControlTextarea1" class="form-label">Días de atención (fin)</label>
                            <input type="date" name="fecha_fin" id="calendario" class="form-control datetimepicker" placeholder="Selecciona Fecha" required style="width: 220px;">
                        </div>                                                                       
                    </div>
                    <div class="row"><br>
                    <div class="col">
                        <label for="exampleFormControlTextarea1" class="form-label">Horario de atención (inicia)</label>
                        <input type="time" name="horario_inicio" id="horario_inicio" class="form-control datetimepicker" placeholder="Selecciona Fecha" required style="width: 220px;">
                    </div>
                    <div class="col">
                        <label for="exampleFormControlTextarea1" class="form-label">Horario de atención (fin)</label>
                        <input type="time" name="horario_fin" id="horario_fin" class="form-control datetimepicker" placeholder="Selecciona Fecha" required style="width: 220px;">
                    </div> 
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="col">Duración Trámite (MINUTOS):</label>
                                <input type="text" class="form-control" id="duracion"  name="duracion"  style="width: 350px; text-transform: uppercase;" >
                            </div>
                        </div>
                        <!-- <div class="col">
                            <div class="col">Tiempo Holgura (MINUTOS):</label>
                                <input type="text" class="form-control" id="holgura"  name="holgura"  style="width: 350px; text-transform: uppercase;" >
                            </div>
                        </div> -->
                        <div class="col">
                            <div class="col">Personas por Trámite:</label>
                                <input type="text" class="form-control" id="personas"  name="personas"  style="width: 350px; text-transform: uppercase;" >
                            </div>
                        </div>
                        </div>
                        <br>
                    <div class="text-center">
                      <button  type="submit" class="btn btn-secondary">Guardar</button>
                  </div>        
              </form>
              
            </div>
        </div>
    </div>
</div>


        <!-- En la vista -->
        
        
@endsection
<script src="/node_modules/@fullcalendar/core/main.js"></script>
    <script src="/node_modules/@fullcalendar/daygrid/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.render();
            var calendarEl = document.getElementById('calendario');
             calendarEl.render();
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

               

