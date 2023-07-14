
/* Cancela una cita */

document.getElementById("bCancelarCita").onclick = function(){

    $.ajax({
        url: '/resumen/CancelaCita',
        data: $("#form-cita").serialize(),
        type: 'POST',
        dataType: 'json',
      
        success: function (json) {
      
          location.reload();
      
        },
        error: function (xhr, status) {
          alert('Error');
        }
      
      });

}