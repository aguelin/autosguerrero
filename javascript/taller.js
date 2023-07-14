
// Cambia el color de los botones de las citas para conocer si están disponibles o no

var bReservar = document.querySelectorAll("#reservar");

    $.ajax({
        url: '/taller/Mostrar',
        data: "",
        type: 'GET',
        dataType: 'json',
    
        success: function (resp) {

            for (let i = 0; i < resp.length; i++) {
                if (resp[i].borrado == 1) {
                  bReservar[i].disabled = true;
                  bReservar[i].style.background = "#FF3131";
                  bReservar[i].style.borderColor = "#FF3131";
                  bReservar[i].value = "No disponible";
                } else {
                  bReservar[i].disabled = false;
                  bReservar[i].style.background = "#0d6efd";
                  bReservar[i].style.borderColor = "#0d6efd";
                  bReservar[i].value = "Reservar";
                }
              }
    
        },
        error: function (xhr, status) {
          alert("Error");
        }
  });

  





