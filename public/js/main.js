///Carga de extractos///
function validarExt() {
  var archivoInput = document.getElementById('archivoInput');
  var archivoRuta = archivoInput.value;
  var extPermitidas = /(.txt || .exc || .csv || .xlsx)$/i;

  if (!extPermitidas.exec(archivoRuta)) {
    var mensajeError = "Selecione un archivo .txt , .exc , .csv";
    var divError = document.createElement('div');
    divError.innerHTML = '<div class="alert alert-danger alert-dismissible fade show fixed-bottom ml-auto mb-3 mr-3 w-25" role="alert"><i class="bi bi-exclamation-triangle me-2"></i>' + mensajeError + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    document.body.appendChild(divError.firstChild);

    archivoInput.value = '';
    return false;
  }
}

function selectAll() {
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');
  for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = document.getElementById("seleccionarTodos").checked;
  }
}

window.addEventListener('DOMContentLoaded', () => {
  const alertElements = document.querySelectorAll('.alert');

  alertElements.forEach(alertElement => {
    alertElement.addEventListener('transitionend', () => {
      if (!alertElement.classList.contains('show')) {
        alertElement.remove();
      }
    });
    setTimeout(() => {
      alertElement.style.transform = 'translateX(150%)';
    }, 3000);
  });
});



