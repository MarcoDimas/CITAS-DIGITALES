<script>
    function searchTable() {
        // Obtener el valor de búsqueda
        var searchText = document.getElementById("searchInput").value.toLowerCase();

        // Obtener la tabla y las filas de la misma
        var table = document.getElementById("resultados");
        var rows = table.getElementsByTagName("tr");

        // Recorrer las filas de la tabla
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            var cells = row.getElementsByTagName("td");
            var found = false;

            // Recorrer las celdas de la fila actual
            for (var j = 0; j < cells.length; j++) {
                var cell = cells[j];
                if (cell.innerHTML.toLowerCase().indexOf(searchText) > -1) {
                    found = true;
                    break;
                }
            }

            // Ocultar o mostrar la fila según el resultado de la búsqueda
            if (found) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    }

    function filtrarCuentas(value) {
        const cuentasB = @json($cuentas);
        //console.log(cuentasB);
        const cuentasFiltradas = cuentasB.filter(key => key.clave_sap == value);
        const cuentasUnicas = new Set(cuentasFiltradas.map(key => key.cuenta_bancaria));
        const cuentasArray = Array.from(cuentasUnicas);

        console.log(cuentasArray);

        const select = document.getElementById("cuenta");

        select.innerHTML = '';

        const defaultOption = document.createElement("option");
        defaultOption.value = '';
        defaultOption.text = 'Seleccione...';
        select.appendChild(defaultOption);

        cuentasArray.forEach(cuenta => {
            const option = document.createElement("option");
            option.value = cuenta;
            option.text = cuenta;
            select.appendChild(option);
        });
    }

    function paginarResultados() {
        const resultados = @json($results);
        console.log(resultados);
        var paginaActual = 1;
        var resultadosPorPagina = 10;
        var totalPaginas = Math.ceil(resultados.length / resultadosPorPagina);

        function mostrarResultados(pagina) {
            var tbody = document.getElementById("resultados");
            tbody.innerHTML = "";

            var inicio = (pagina - 1) * resultadosPorPagina;
            var fin = inicio + resultadosPorPagina;
            var resultadosPaginados = resultados.slice(inicio, fin);

            resultadosPaginados.forEach(function(resultado) {
                var row = document.createElement("tr");
                var lineaCapturaCell = document.createElement("td");
                lineaCapturaCell.textContent = resultado.linea_captura;
                var fechaPagoCell = document.createElement("td");
                fechaPagoCell.textContent = resultado.fecha_pago;
                var importeCell = document.createElement("td");
                importeCell.textContent = "$" + resultado.monto;
                var formaPagoCell = document.createElement("td");
                formaPagoCell.textContent = resultado.forma_pago;
                var cuentaCell = document.createElement("td");
                cuentaCell.textContent = resultado.cuenta;
                var acreditadaCell = document.createElement("td");
                acreditadaCell.textContent = resultado.aut ? "Sí" : "No";
                var documentoCell = document.createElement("td");
                documentoCell.textContent = resultado.nombre_doc;

                row.appendChild(lineaCapturaCell);
                row.appendChild(fechaPagoCell);
                row.appendChild(importeCell);
                row.appendChild(formaPagoCell);
                row.appendChild(cuentaCell);
                row.appendChild(acreditadaCell);
                row.appendChild(documentoCell);

                tbody.appendChild(row);
            });
        }

        function mostrarPaginacion() {
            var paginacion = document.getElementById("paginacion");
            paginacion.innerHTML = "";

            var ul = document.createElement("ul");
            ul.classList.add("pagination");

            var firstLi = document.createElement("li");
            firstLi.classList.add("page-item");
            var firstLink = document.createElement("a");
            firstLink.classList.add("page-link");
            firstLink.href = "#";
            firstLink.setAttribute("aria-label", "First");
            firstLink.innerHTML = '<span aria-hidden="true">&laquo;&laquo;</span>';
            firstLi.appendChild(firstLink);
            ul.appendChild(firstLi);

            firstLink.addEventListener("click", function() {
                paginaActual = 1;
                mostrarResultados(paginaActual);
                mostrarPaginacion();
            });

            var prevLi = document.createElement("li");
            prevLi.classList.add("page-item");
            var prevLink = document.createElement("a");
            prevLink.classList.add("page-link");
            prevLink.href = "#";
            prevLink.setAttribute("aria-label", "Previous");
            prevLink.innerHTML = '<span aria-hidden="true">&laquo;</span>';
            prevLi.appendChild(prevLink);
            ul.appendChild(prevLi);

            prevLink.addEventListener("click", function() {
                if (paginaActual > 1) {
                    paginaActual--;
                    mostrarResultados(paginaActual);
                    mostrarPaginacion();
                }
            });

            // Calcular el rango de números de página a mostrar
            var rangoInicio = Math.max(1, paginaActual - 4);
            var rangoFin = Math.min(rangoInicio + 9, totalPaginas);

            for (var i = rangoInicio; i <= rangoFin; i++) {
                var li = document.createElement("li");
                li.classList.add("page-item");
                var link = document.createElement("a");
                link.classList.add("page-link");
                link.href = "#";
                link.textContent = i;

                if (i === paginaActual) {
                    li.classList.add("active");
                }

                link.addEventListener("click", function() {
                    paginaActual = parseInt(this.textContent);
                    mostrarResultados(paginaActual);
                    mostrarPaginacion();
                });

                li.appendChild(link);
                ul.appendChild(li);
            }

            var nextLi = document.createElement("li");
            nextLi.classList.add("page-item");
            var nextLink = document.createElement("a");
            nextLink.classList.add("page-link");
            nextLink.href = "#";
            nextLink.setAttribute("aria-label", "Next");
            nextLink.innerHTML = '<span aria-hidden="true">&raquo;</span>';
            nextLi.appendChild(nextLink);
            ul.appendChild(nextLi);

            nextLink.addEventListener("click", function() {
                if (paginaActual < totalPaginas) {
                    paginaActual++;
                    mostrarResultados(paginaActual);
                    mostrarPaginacion();
                }
            });

            var lastLi = document.createElement("li");
            lastLi.classList.add("page-item");
            var lastLink = document.createElement("a");
            lastLink.classList.add("page-link");
            lastLink.href = "#";
            lastLink.setAttribute("aria-label", "Last");
            lastLink.innerHTML = '<span aria-hidden="true">&raquo;&raquo;</span>';
            lastLi.appendChild(lastLink);
            ul.appendChild(lastLi);

            lastLink.addEventListener("click", function() {
                paginaActual = totalPaginas;
                mostrarResultados(paginaActual);
                mostrarPaginacion();
            });

            paginacion.appendChild(ul);
        }


        mostrarResultados(paginaActual);
        mostrarPaginacion();
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Verificar si el div está presente
        var divResultados = document.querySelector(".result-tag");
        if (divResultados !== null) {
            // Llamar a la función paginarResultados
            paginarResultados();
        }
    });
</script>