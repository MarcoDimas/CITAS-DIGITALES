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
            Consulta de Citas
        </div>
        @if (session('reload'))
        <script>
            setTimeout(function() {
                location.reload();
            }, 1700); 
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
                <div class="card-header">Citas registradas</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaUsuarios" class="table table-striped table-bordered table-hover">
                            <thead class="text-white bg-secondary">
                                <tr>
                                    <th>Dependencia</th>
                                    <th>Trámite</th>
                                    <th>SubTrámite</th>
                                    <th>Nombre</th>
                                    <th>RFC</th>
                                    <th>Email</th>
                                    <th>Estatus</th>
                                    <th>Fecha de la Cita</th>                                    
                                    <th>Cancelada</th>
                                    <th>Actualizar</th>
                                    <th>Cancelar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($citas as $cita)
                                    <tr>
                                        <td>{{ $cita->tramite->area->dependencia->descripcion }}</td>
                                        <td>{{ $cita->tramite->descripcion }}</td>
                                        <td>{{ $cita->subtramite->descripcion }}</td>

                                        <td>{{ $cita->nombre }} {{ $cita->ape_paterno }} {{ $cita->ape_materno }}</td>
                                        <td>{{ $cita->rfc }}</td>
                                        <td>{{ $cita->email }}</td>
                                        <td>
                                            @if ($cita->estatus)
                                                <i class="bi-sm bi-x-square"> No atendida</i>
                                                <!-- Icono para estado activo -->
                                            @else
                                                <i class="bi-sm  bi-check2-square"> Atendida</i>
                                                <!-- Icono para estado inactivo -->
                                            @endif
                                        </td>
                                        <td>{{ $cita->fecha }} {{ $cita->horario }} </td>
                                        <td class="@if ($cita->cancelada) text-danger @endif">
                                            @if ($cita->cancelada)
                                                <i class="bi-sm bi-check2-square"> Cancelada</i>
                                            @else
                                                <!--i class="bi-sm bi-x-square"> No Cancelada</i>-->
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#modalActualizar{{ $cita->id }}">
                                                Actualizar
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#eliminarModal{{ $cita->id }}">
                                                Cancelar
                                            </button>
                                      
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10">No hay citas registradas</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    @foreach ($usersWithProfilesAndOrders as $cita)
        <div class="modal fade" id="modalActualizar{{ $cita->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Actualizar Estatus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario para la actualización -->
                        <form action="{{ route('actualizar.estatus', ['id' => $cita->id]) }}" method="post">

                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="estatus">Estatus:</label>
                                <select class="form-control" id="estatus" name="estatus">
                                    <option value="0" {{ $cita->estatus == 0 ? 'selected' : '' }}>Atendida</option>
                                    <option value="1" {{ $cita->estatus == 1 ? 'selected' : '' }}>No Atendida</option>
                                </select>
                            </div>


                            <button type="submit" class="btn btn-success">Actualizar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal CANCELAR CITA -->
        <div class="modal fade" id="eliminarModal{{ $cita->id }}" tabindex="-1" role="dialog"
            aria-labelledby="cancelarModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelarModalLabel">Confirmar Cancelación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas cancelar esta cita?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <form id="formCancelar" action="{{ route('cancelar.cita', ['id' => $cita->id]) }}" method="POST">
                            @csrf
                            @method('PUT') <!-- Agregar método PUT -->
                            <button type="submit" class="btn btn-danger">Cancelar Cita</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
