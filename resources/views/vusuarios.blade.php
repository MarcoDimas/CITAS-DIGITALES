@extends('layouts.layout')

@section('content')

    <head>
        <!-- Utiliza solo Bootstrap 5 -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

        <!-- Utiliza solo DataTables con Bootstrap 5 -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

        <!-- jQuery -->
        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- DataTables con Bootstrap 5 -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js">
        </script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js">
        </script>
        <style>
            /* Ajuste de la altura máxima y el overflow */

            .scrollable-container {
                max-height: 500px;
                /* Ajusta según tus necesidades */
                overflow-y: auto;
            }

            .card-body {
                max-height: 370px;
                /* Establece la altura máxima a la que quieres que se muestre el contenido antes de que aparezca el scroll. Puedes ajustar esto según tus necesidades. */
                overflow-y: auto;
                /* Añade un scroll vertical si el contenido es más alto que la altura máxima establecida. */
            }

            /* Ajuste del ancho de las columnas */

            .table th,
            .table td {
                white-space: nowrap;
                width: auto;
            }

            /* Alineación del texto en las celdas */

            .table th,
            .table td {
                text-align: center;
            }

            /* Reducir el tamaño de la fuente */

            .table th,
            .table td {
                font-size: 12px;
                /* Ajusta el tamaño de la fuente según tus necesidades */
            }

            /* Reducir el espaciado entre filas y columnas */

            .table th,
            .table td {
                padding: 0.25rem;
                /* Ajusta el espaciado según tus necesidades */
            }

            .tamaño {
                width: 1000px;
                height: 370px;
            }
        </style>

    </head>
    <div class="container" style="margin-top: -45px;">
        <!--div class="ms-5 titulo borderBottom--Guinda mt-2 text-big text-morado text-semibold Gibson Medium">-->
        <div class="ms-5 titulo   mt-2 text-big text-semibold Gibson Medium"
            style="color:#61727b; border-bottom: 2px solid #61727b;">
            Ver Usuarios
        </div>
        
        @if (session('reload'))
        <script>
            setTimeout(function() {
                location.reload();
            }, 1700); // Espera 2 segundos antes de recargar
        </script>
    @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-auto text-center mt-4" role="alert"
                style="max-width: 700px;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container scrollable-container">
            <div class="card my-4 tamaño">
                <div class="card-header">Usuarios registrados</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaUsuarios" class="table table-striped table-bordered table-hover">
                            <thead class="text-white bg-secondary">
                                <tr>
                                    <th>Dependencia</th>
                                    <th>Nombre</th>
                                    <th>Correo Electrónico</th>
                                    <th>Rol</th>
                                    <th>Estatus</th>
                                    <th>Modificar</th>
                                    <th>Desactivar Usuario</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($usersWithDependencias as $vusuario)
                                @if($vusuario->id_roles != 1 || Auth::user()->id_roles == 1)
                                    <tr>
                                        <td>{{ $vusuario->dependencia_descripcion }}</td>
                                        <td>{{ $vusuario->name }}</td>
                                        <td>{{ $vusuario->email }}</td>
                                        <td>{{ $vusuario->roles_descripcion }}</td>
                                        <td>
                                            @if ($vusuario->estatus)
                                                <i class="bi-sm  bi-check2-square"> Activo</i>
                                            @else
                                                <i class="bi-sm bi-x-square"> Inactivo</i>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Botón para abrir el modal -->
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#editarPasswordModal{{ $vusuario->id }}">
                                                Editar Contraseña
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#desactivarUsuarioModal{{ $vusuario->id }}">
                                                Desactivar Usuario
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- MODAL MODFICART CONTRASEÑA-->
@foreach ($usersWithDependencias as $vusuario)
    <!-- Modal de edición de contraseña -->
    <div class="modal fade" id="editarPasswordModal{{ $vusuario->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editarPasswordModalLabel" aria-hidden="true">
        <!-- Contenido del modal -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarPasswordModalLabel">Editar Contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{ route('actualizar.password', ['id' => $vusuario->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="password">Nueva Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de desactivación del usuario -->
    <div class="modal fade" id="desactivarUsuarioModal{{ $vusuario->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Desactivar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea desactivar este usuario?</p>
                    <p>Estado actual: 
                        @if ($vusuario->estatus)
                            Activo
                        @else
                            Inactivo
                        @endif
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form action="{{ route('usuarios.desactivar', $vusuario->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger">Desactivar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
