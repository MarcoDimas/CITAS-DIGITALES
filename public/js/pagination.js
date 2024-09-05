$(document).ready(function() {
    // Agrega una bandera para controlar si se está realizando una solicitud AJAX
    var isLoading = false;

    // Agrega un manejador de eventos para el formulario de filtro
    $('#filtro-form').on('submit', function(e) {
        e.preventDefault(); // Evita que se envíe el formulario de manera tradicional

        if (isLoading) {
            // Evita enviar múltiples solicitudes AJAX simultáneamente
            return;
        }

        isLoading = true; // Establece isLoading a true durante la solicitud AJAX

        // Realiza una solicitud AJAX para obtener los resultados paginados
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                // Actualiza solo la tabla de resultados y la paginación
                $('#results-container').html($(data).find('#results-container').html());
                isLoading = false; // Restablece isLoading a false después de la solicitud
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                isLoading = false; // Asegura que isLoading se restablezca incluso en caso de error
            }
        });
    });

    $('#results-container .custom-pagination').on('click', 'a.page-link', function(e) {
        e.preventDefault();
    
        if (isLoading) {
            return;
        }
        isLoading = true;
    
        var url = $(this).attr('href');
    
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                $('#results-container').html($(data).find('#results-container').html());
                isLoading = false;
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                isLoading = false;
            }
        });
    });
});
