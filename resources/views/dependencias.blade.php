@extends('layouts.layout')

@section('content')
<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<div class="container">
    <!--div class="ms-5 titulo borderBottom--Guinda mt-2 text-big text-morado text-semibold Gibson Medium">-->
    <div class="ms-5 titulo   mt-2 text-big text-semibold Gibson Medium" style="color:#61727b; border-bottom: 2px solid #61727b;">
        ALTA DEPENDENCIA
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
        
        <div class="card my-2">
            <div class="card-header">Registrar Dependencia</div>
            <div class="card-body">
                <form method="POST" action="{{ route('guardaDatos') }}">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="col">
                                <label for="">Dependencia:</label>
                                <input type="text" class="form-control" id="descripcion"  name="descripcion"  style="width: 350px; text-transform: uppercase;" >
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


@endsection

               

