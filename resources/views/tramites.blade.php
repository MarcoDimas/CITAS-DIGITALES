@extends('layouts.layout')

@section('content')
<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
</head>

<div class="container">
    <!--div class="ms-5 titulo borderBottom--Guinda mt-2 text-big text-morado text-semibold Gibson Medium">-->
    <div class="ms-5 titulo   mt-2 text-big text-semibold Gibson Medium" style="color:#61727b; border-bottom: 2px solid #61727b;">
        ALTA TRÁMITES
    </div>

    
    @if(session('success'))
    <div class="alert alert-success" style="margin-top: 4px;">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger" style="margin-top: 4px;">{{ session('error') }}</div>
@endif

@if (session('reload'))
        <script>
            setTimeout(function() {
                location.reload();
            }, 1700); // Espera 2 segundos antes de recargar
        </script>
    @endif

    
    <div class="container">
        
        <div class="card my-4">
            <div class="card-header">Registrar Trámites</div>
            <div class="card-body">
                <form method="POST" action="{{ route('guardarDatos') }}">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="">Dependencia:</label>
                            <br>
                             <select class="form-control" name="id_dependencia" id="id_dependencia" style="width: 330px;  display: block; background-color: #f9f9f9; text-transform: uppercase;">
                                <option disabled>SELECCIONA DEPENDENCIA</option> 
                                @if(Auth::user()->id_roles == 1)
                                    <!-- Si el usuario tiene el rol 1, mostrar todas las dependencias -->
                                    @foreach($dependencias as $dependencia)
                                        <option value="{{ $dependencia->id }}">{{ $dependencia->descripcion }}</option>
                                    @endforeach 
                                @else
                                    <!-- Si el usuario no tiene el rol 1, mostrar solo su dependencia asociada -->
                                    @foreach($dependencias as $dependencia)
                                        @if($dependencia->id == Auth::user()->id_dependencia)
                                            <option value="{{ $dependencia->id }}">{{ $dependencia->descripcion }}</option>
                                        @endif
                                    @endforeach 
                                @endif
                            </select>

                        </div>
                        <div class="col">
                            <label for="">Dirección:</label>
                            <select id="select2" name="id_area" class="form-control" style="width: 310px; display: block; background-color: #f9f9f9; text-transform: uppercase;">
                                     <option disabled>SELECCIONA OFICINA</option>
                                         @foreach($areas as $area)
                                           <option value="{{ $area->id }}">{{ $area->descripcion }}</option>
                                          @endforeach 
                            </select>
                        </div>
                        <div class="col">
                            <label for="exampleFormControlTextarea1" class="form-label">Descripción Trámite</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="1"></textarea>
                        </div> 
                      </div>
                      <div class="row">  
                        <div class="col-6">
                            <label for="exampleFormControlTextarea1" class="form-label">Domicilio</label>
                            <textarea class="form-control" id="domicilio" name="domicilio" rows="1"></textarea>
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
 
@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Evento cuando cambia el valor del primer select
        $('#id_dependencia').change(function () {
            var selectedValue = $(this).val();

            // Hacer una solicitud AJAX para obtener datos filtrados
            $.ajax({
                url: "{{ route('obtenerAreasPorDependencia') }}",
                type: 'GET',
                data: {selectedValue: selectedValue},
                success: function (data) {
                    // Limpiar el segundo select
                    $('#select2').empty();

                    // Llenar el segundo select con los datos filtrados
                    $.each(data, function (key, value) {
                        $('#select2').append('<option value="' + value.id + '">'  +   value.descripcion + '</option>');
                    });
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    });
</script>
  

