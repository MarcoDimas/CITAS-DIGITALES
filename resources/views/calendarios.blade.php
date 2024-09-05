@extends('layouts.layout')

@section('content')

    <head>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    </head>
    <style>
        .card-body {
            max-height: 370px;
            /* Establece la altura máxima a la que quieres que se muestre el contenido antes de que aparezca el scroll. Puedes ajustar esto según tus necesidades. */
            overflow-y: auto;
            /* Añade un scroll vertical si el contenido es más alto que la altura máxima establecida. */
        }

        /* En tu archivo de estilos CSS */
        .error-message {
            color: #721c24;
            /* Color del texto para errores */
            background-color: #f8d7da;
            /* Color de fondo para errores */
            border: 1px solid #f5c6cb;
            /* Borde para errores */
            padding: 10px;
            /* Espaciado interior */
            margin-bottom: 10px;
            /* Espaciado inferior */
        }

        input[type="date"]:invalid {
            color: #999;
            /* Cambia el color del texto a gris */
            background-color: #f0f0f0;
            /* Cambia el color de fondo a un gris más claro */
        }
    </style>


    <div class="container" style="margin-top: -45px;">
        <!--div class="ms-5 titulo borderBottom--Guinda mt-2 text-big text-morado text-semibold Gibson Medium">-->
        <div class="ms-5 titulo   mt-2 text-big text-semibold Gibson Medium"
            style="color:#61727b; border-bottom: 2px solid #61727b;">
            Citas
        </div>
        <div class="container" style="margin-top: -15px;">

            <div class="card my-4">
                <div class="card-header">Registrar Citas</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('guardarDatoscit') }}" id="miFormulario">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label for="id_dependencia" class="col-form-label"><i class="bi-sm  bi-clipboard-fill"></i>
                                    Trámite:</label>
                                <br>
                                <select class="form-control" name="id_tramite" id="select1" onchange="cargarOpciones()"
                                    style="width: 330px;  display: block; background-color: #f9f9f9;"
                                    @if ($consultaCita != null) disabled @endif>
                                    @if (!isset($data['id_tramite']))
                                        <option value="" selected disabled>SELECCIONA TRÁMITE</option>
                                    @endif
                                    @foreach ($tramites as $tramite)
                                        <option value="{{ $tramite->id }}">{{ $tramite->descripcion }}</option>
                                    @endforeach
                                </select>
                                @error('id_tramite')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="direccion" class="col-form-label"><i class="bi-sm bi-clipboard2-check-fill"></i>
                                    Subtrámite:</label>
                                <select id="select2" name="id_subtramite" class="form-control"
                                    style="width: 310px;  display: block; background-color: #f9f9f9;"
                                    @if ($consultaCita != null) disabled @endif>
                                    @if (isset($data['id_subtramite']))
                                        @foreach ($subtramites as $subtramite)
                                            <option value="{{ $subtramite->id }}">{{ $subtramite->descripcion }}</option>
                                        @endforeach
                                    @else
                                        <option>SELECCIONA SUBTRAMITE</option>
                                    @endif
                                </select>
                                @error('id_subtramite')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="id_dependencia" class="col-form-label"><i class="bi-sm bi-calendar2-week"></i>
                                    Fecha:</label>
                                <input type="date" name="fecha" id="fecha_inicio" value="{{ date('Y-m-d') }}"
                                    class="form-control " placeholder="Selecciona Fecha" required style="width: 220px;"
                                    min="{{ date('Y-m-d') }}" required @if ($consultaCita != null) disabled @endif>

                            </div>
                            <div class="col">
                                <label for="direccion" class="col-form-label"><i class="bi-sm bi-alarm"></i> Hora:</label>
                                <select class="form-control" name="horario" id="id_hora" onchange="cargarOpciones()"
                                    style="width: 330px;  display: block; background-color: #f9f9f9; text-transform: uppercase;"
                                    required @if ($consultaCita != null) disabled @endif>

                                    @if (isset($data['id_tramite']))
                                        @foreach ($horasEnRango as $hora)
                                            <option value="{{ $hora }}">{{ $hora }}</option>
                                        @endforeach
                                    @else
                                        <option selected>SELECCIONA HORARIO</option>
                                    @endif
                                </select>
                                @if ($errors->has('horario'))
                                    <div class="error-message" id="horario-error">
                                        {{ $errors->first('horario') }}
                                        <script>
                                            // Ocultar el mensaje de error después de 5 segundos (5000 milisegundos)
                                            setTimeout(function() {
                                                document.getElementById('horario-error').style.display = 'none';
                                            }, 5000);
                                        </script>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="nombre" class="col-form-label"><i class="bi-sm bi-person-fill"></i>
                                    Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    style="width: 350px;" @if ($consultaCita != null) disabled @endif
                                    value="{{ old('nombre') }}">
                                @if ($errors->has('nombre'))
                                    <div class="error-message" id="nombre-error">
                                        {{ $errors->first('nombre') }}
                                        <script>
                                            // Ocultar el mensaje de error después de 5 segundos (5000 milisegundos)
                                            setTimeout(function() {
                                                document.getElementById('nombre-error').style.display = 'none';
                                            }, 5000);
                                        </script>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <label for="paterno" class="col-form-label"><i class="bi-sm bi-person-fill"></i>
                                    Apellido
                                    Paterno:</label>
                                <input type="text" class="form-control" id="ape_paterno" name="ape_paterno"
                                    style="width: 350px;" @if ($consultaCita != null) disabled @endif
                                    value="{{ old('ape_paterno') }}">

                                @if ($errors->has('ape_paterno'))
                                    <div class="error-message" id="ape_paterno-error">
                                        {{ $errors->first('ape_paterno') }}
                                        <script>
                                            // Ocultar el mensaje de error después de 5 segundos (5000 milisegundos)
                                            setTimeout(function() {
                                                document.getElementById('ape_paterno-error').style.display = 'none';
                                            }, 5000);
                                        </script>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <label for="materno" class="col-form-label"><i class="bi-sm bi-person-fill"></i>
                                    Apellido
                                    Materno:</label>
                                <input type="text" class="form-control" id="ape_materno" name="ape_materno"
                                    style="width: 350px;" @if ($consultaCita != null) disabled @endif
                                    value="{{ old('ape_materno') }}">

                                @if ($errors->has('ape_materno'))
                                    <div class="error-message" id="ape_materno-error">
                                        {{ $errors->first('ape_materno') }}
                                        <script>
                                            // Ocultar el mensaje de error después de 5 segundos (5000 milisegundos)
                                            setTimeout(function() {
                                                document.getElementById('ape_materno-error').style.display = 'none';
                                            }, 5000);
                                        </script>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="nombre" class="col-form-label"><i class="bi-sm bi-person-badge"></i>
                                    RFC:</label>
                                <input type="text" class="form-control" id="rfc" name="rfc"
                                    style="width: 350px; text-transform: uppercase;" maxlength="13"
                                    pattern="[A-Za-z]{4}[0-9]{6}[A-Za-z0-9]{3}"
                                    @if ($consultaCita != null) disabled @endif value="{{ old('rfc') }}">

                                @if ($errors->has('rfc'))
                                    <div class="error-message" id="rfc-error">
                                        {{ $errors->first('rfc') }}
                                        <script>
                                            // Ocultar el mensaje de error después de 5 segundos (5000 milisegundos)
                                            setTimeout(function() {
                                                document.getElementById('rfc-error').style.display = 'none';
                                            }, 5000);
                                        </script>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <label for="paterno" class="col-form-label"><i class="bi-sm bi-envelope-at-fill"></i>
                                    Correo Electrónico:</label>

                                <input type="email" class="form-control" id="email" name="email"
                                    style="width: 350px;" @if ($consultaCita != null) disabled @endif
                                    value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <div class="error-message" id="email-error">
                                        {{ $errors->first('email') }}
                                        <script>
                                            // Ocultar el mensaje de error después de 5 segundos (5000 milisegundos)
                                            setTimeout(function() {
                                                document.getElementById('email-error').style.display = 'none';
                                            }, 5000);
                                        </script>
                                    </div>
                                @endif

                            </div>
                            <div class="col">
                                <label for="materno" class="col-form-label"><i class="bi-sm bi-telephone-fill"></i>
                                    Número de Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono"
                                    style="width: 350px;" maxlength="10"
                                    @if ($consultaCita != null) disabled @endif value="{{ old('telefono') }}">

                                @if ($errors->has('telefono'))
                                    <div class="error-message" id="telefono-error">
                                        {{ $errors->first('telefono') }}
                                        <script>
                                            // Ocultar el mensaje de error después de 5 segundos (5000 milisegundos)
                                            setTimeout(function() {
                                                document.getElementById('telefono-error').style.display = 'none';
                                            }, 5000);
                                        </script>
                                    </div>
                                @endif
                            </div>
                        </div><br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-secondary"
                                @if ($consultaCita != null) disabled @endif> Agendar </button>
                        </div>
                    </form><br>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="miModalLabel">¡Advertencia!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center">¡Seleccionaste un sábado o domingo! Por favor, elige otro día.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function validarFormulario() {
        var select1 = document.getElementById("select1");
        var selectedValue = select1.options[select1.selectedIndex].value;

        if (selectedValue === "") {
            alert("Por favor, selecciona un Trámite válido.");
            return false; // Evita que el formulario se envíe si la validación falla
        }

        // Otras validaciones si es necesario

        return true; // Permite que el formulario se envíe si todas las validaciones pasan
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {

        /*SELECCIONAR SUBTRAMITE */
        // Evento cuando cambia el valor del primer select
        $('#select1').change(function() {
            var selectedValue = $(this).val();

            // Hacer una solicitud AJAX para obtener datos filtrados
            $.ajax({
                url: "{{ route('obtenerDatosFiltradoss') }}", // Reemplaza con la ruta de tu controlador
                type: 'GET',
                data: {
                    selectedValue: selectedValue
                },
                success: function(data) {
                    // Limpiar el segundo select
                    $('#select2').empty();
                    $('#select2').append(
                        '<option value="" selected disabled>Selecciona</option>');
                    // Llenar el segundo select con los datos filtrados
                    $.each(data, function(key, value) {
                        $('#select2').append('<option value="' + value.id + '">' +
                            value.descripcion + '</option>');
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        /*SELECCIONAR FECHA */
        // Evento cuando cambia el valor del primer select
        $('#select2,#fecha_inicio').change(function() {


            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Configurar AJAX con el token CSRF
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            var selectedValue = $(this).val();

            // Hacer una solicitud AJAX para obtener datos filtrados
            $.ajax({
                url: "{{ route('ObtenerHoras') }}", // Reemplaza con la ruta de tu controlador
                type: 'POST',
                data: {
                    fecha: $("#fecha_inicio").val(),
                    id_subtramite: $("#select2").val()
                },
                success: function(data) {
                    console.log(data);
                    // Limpiar el segundo select
                    $('#id_hora').empty();

                    // Llenar el segundo select con los datos filtrados
                    $.each(data, function(key, value) {
                        $('#id_hora').append('<option value="' + value + '">' +
                            value + '</option>');
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener la referencia al elemento de fecha
        var fechaInput = document.getElementById('fecha_inicio');

        // Escuchar el evento de cambio en la fecha
        fechaInput.addEventListener('input', function() {
            // Obtener el día de la semana (0 = domingo, 1 = lunes, ..., 6 = sábado)
            var fechaSeleccionada = new Date(this.value);
            var diaDeLaSemana = fechaSeleccionada.getDay();

            // Deshabilitar sábados (6) y domingos (0)
            if (diaDeLaSemana === 5 || diaDeLaSemana === 6) {
                // Mostrar modal en lugar de alerta
                $('#miModal').modal('show');

                // Limpiar la fecha seleccionada
                this.value = '';
            }
        });
    });
</script>
