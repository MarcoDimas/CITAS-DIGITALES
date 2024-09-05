<!-- Modal para crear usuarios -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Crear usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre" class="col-form-label"><i class="bi-sm bi-person-fill"></i> Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="name" placeholder="Nombre" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="paterno" class="col-form-label"><i class="bi-sm bi-person-fill"></i> Paterno:</label>
                            <input type="text" class="form-control" id="paterno" name="paterno" placeholder="Apellido paterno" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="materno" class="col-form-label"><i class="bi-sm bi-person-fill"></i> Materno:</label>
                            <input type="text" class="form-control" id="materno" name="materno" placeholder="Apellido materno" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="correo" class="col-form-label"><i class="bi-sm bi-envelope-fill"></i> Correo:</label>
                            <input type="email" class="form-control" id="correo" name="email" placeholder="Correo electrónico" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="password" class="col-form-label"><i class="bi-sm bi-lock-fill"></i> Contraseña:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                        </div>
                    </div>
                    <!--div class="col-md-4">
                        <div class="form-group">
                            <label for="password_confirmation" class="col-form-label"><i class="bi-sm bi-lock-fill"></i> Confirmar contraseña:</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirma tu contraseña" required>
                        </div>
                    </div-->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="password" class="col-form-label"><i class="bi-sm bi-lock-fill"></i> Dependencia:</label>
                            <select  class="form-control"  name="id_dependencia" id="select1" onchange="cargarOpciones()" style="width: 330px;  display: block; background-color: #f9f9f9;">
                                <option selected>SELECCIONA DEPENDENCIA</option> 
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Dirección:</label>
                            <select id="select2" name="id_area" class="form-control" style="width: 310px;  display: block; background-color: #f9f9f9;">
                                <option>SELECCIONA OFICINA</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="form-label"><i class="bi-sm bi-people-fill"></i> Rol / Roles:</label>
                            <div class="form-row ms-5">
                                <div class="col-md-4 form-check">
                                    <input class="form-check-input" type="checkbox" id="rol-admin" name="administrador" value="1">
                                    <label class="form-check-label" for="rol-admin">Administrador</label>
                                </div>
                                <div class="col-md-4 form-check">
                                    <input class="form-check-input" type="checkbox" id="rol-usuario" name="usuario" value="1">
                                    <label class="form-check-label" for="rol-usuario">Operador</label>
                                </div>
                                <div class="col-md-4 form-check">
                                    <input class="form-check-input" type="checkbox" id="rol-reporteria" name="reporteria" value="1">
                                    <label class="form-check-label" for="rol-reporteria">Reporteria</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-Guinda">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Evento cuando cambia el valor del primer select
        $('#select1').change(function () {
            var selectedValue = $(this).val();

            // Hacer una solicitud AJAX para obtener datos filtrados
            $.ajax({
                url: 'http://localhost:80/citas-en-linea-mvc/public/obtenerDatosfil', // Reemplaza con la ruta de tu controlador
                type: 'GET',
                data: {selectedValue: selectedValue},
                success: function (data) {
                    // Limpiar el segundo select
                    $('#select2').empty();

                    // Llenar el segundo select con los datos filtrados
                    $.each(data, function (key, value) {
                        $('#select2').append('<option value="' + value.id_area + '">' + value.descripcion + '</option>');
                    });
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    });
</script>