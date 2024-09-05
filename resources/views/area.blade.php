@extends('layouts.layout')

@section('content')
<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<div class="container">
    <div class="ms-5 titulo   mt-2 text-big text-semibold Gibson Medium" style="color:#61727b; border-bottom: 2px solid #61727b;">
        ALTA DIRECCIÓN
    </div>

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
    
    <div class="container">
        
        <div class="card my-4">
            <div class="card-header">Registrar Dirección</div>
            <div class="card-body">
                <form method="POST" action="{{ route('guardaDato') }}">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="">Dependencia:</label>
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
                        </div>
                        <div class="col">
                            <div class="col">
                                <label for="">Dirección:</label>
                                <input type="text" class="form-control" id="descripcion"  name="descripcion"  style="width: 350px;">
                            </div>
                        </div>
                    </div><br><br>
                    <div class="text-center">
                        <button type="submit" class="btn btn-secondary">Guardar</button>
                    </div>                    
                </form>
        
            </div>
        </div>               
    </div>
</div>


@endsection
