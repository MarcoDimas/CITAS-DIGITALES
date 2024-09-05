@extends('layouts.layout')

@section('content')
<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<div class="container" style="margin-top: -45px;">
        <!--div class="ms-5 titulo borderBottom--Guinda mt-2 text-big text-morado text-semibold Gibson Medium">-->
        <div class="ms-5 titulo   mt-2 text-big text-semibold Gibson Medium"
            style="color:#61727b; border-bottom: 2px solid #61727b;">
            ALTA USUARIOS
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

        <div class="container" style="margin-top: -20px;">

        
        <div class="card my-4">
            <div class="card-header">Registrar Usuarios</div>
            <div class="card-body">
                <form method="POST" action="{{ route('guarDatos') }}">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="nombre" class="col-form-label"><i class="bi-sm bi-person-fill"></i> Nombre:</label>
                                <input type="text" class="form-control" id="name"  name="name"  style="width: 350px;">
                        </div>
                        <div class="col">
                            <div class="col">
                                <label for="paterno" class="col-form-label"><i class="bi-sm bi-person-fill"></i> Correo Electrónico:</label>
                                <input type="text" class="form-control" id="email"  name="email"  style="width: 350px;">
                            </div>
                        </div>
                        <div class="col">
                            <div class="col">
                                <label for="password" class="col-form-label"><i class="bi-sm bi-lock-fill"></i> Contraseña:</label>
                                <input type="password" class="form-control" id="password"  name="password"  style="width: 350px;">
                            </div>
                        </div>
                        
                     </div>
                     <div class="row">                    
                        <div class="col">
                            <label for="id_dependencia" class="col-form-label"><i class="bi-sm bi-building-fill"></i> Dependencia:</label>
                            <br>
                            <select  class="form-control"  name="id_dependencia" id="select1"  style="width: 330px;  display: block; background-color: #f9f9f9;">
                            <option selected enabled>SELECCIONA DEPENDENCIA</option> 
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
                            <label for="id_dependencia" class="col-form-label"><i class="bi-sm bi-people-fill"></i> Roles:</label>
                            <br>
                            <select class="form-control" name="id_roles" id="select1" style="width: 330px; display: block; background-color: #f9f9f9;">
                                <option selected>SELECCIONA ROL</option>
                                @if(auth()->user()->id_roles == 1)
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                    @endforeach
                                @elseif(auth()->user()->id_roles == 2 || auth()->user()->id_roles == 3) 
                                    @foreach($roles as $rol)
                                        @if($rol->id == 2 || $rol->id == 3)
                                            <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>


                     </div><br>
                     <br>
                <div class="text-center">
                  <button  type="submit" class="btn btn-secondary">Guardar</button>
              </div>   <BR>                 
        </form>
        
      </div>
  </div>               
</div>
</div>


        <!-- En la vista -->
    
        @endsection

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        
                         

