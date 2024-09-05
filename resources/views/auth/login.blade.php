
@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/Stylos.css') }}" rel="stylesheet">
    <div class="container-fluid h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-10">
                        <img class="imagenLogo" src="{{ asset('imagenes/logoFinanzas.png') }}" alt="imagenLogo" width="150px">
                        <h1 class="Titulo text-guinda text-mega text-semibold mb-1">Citas en Línea</h1>
                        <h2 class="subTitulo text-big text-semibold mb-2">Iniciar Sesión</h2>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email" class="text text-semibold">{{ __('Correo Electrónico') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="text text-semibold">{{ __('Contraseña') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div style="margin-left: 175px;">
                        <button type="submit" class="btn btn-lg" style="background-color: #C9C6C6; border-color: #C9C6C6;">{{ __('Iniciar Sesión') }}</button>
                        </div>

                    </form>

                    @if ($errors->any())
                        <div class="mt-4">
                            <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection