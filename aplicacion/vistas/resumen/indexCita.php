<?php

if((new DateTime($fila["fecha"]) > new DateTime("now")) && (new DateTime($fila["fecha"]) > new DateTime("now"))){

$diasSemana = [1 => "Lunes", 2 => "Martes", 3 => "Miércoles", 4 => "Jueves", 5 => "Viernes"];

?>

<div class="col">
       <div class="card ">

              <div class="card-header">
                     <div class="card-title">
                            <h5><?php echo $diasSemana[date("N", strtotime($fila["fecha"]))] ?></h5>
                     </div>
              </div>

              <div class="card-body d-flex">



                     <div class="d-flex justify-content-around p-3">

                            <h4><?php echo date_format(new DateTime($fila["fecha"]), "d/m/Y") ?></h4>
                            <h4><?php echo $fila["hora"] ?></h4>

                     </div>

                     <div class="card-text">

                            <p>Será atendido por nuestr@ profesional <?php echo $fila["empleado"] ?></p>

                     </div>

              </div>

              <div class="card-footer">
                     <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target=".bCancelarCita">Eliminar</button>
              </div>


       </div>
</div>


<div class="modal fade bCancelarCita" role="dialog" data-bs-backdrop="static">
       <div class="modal-dialog modal-md modal-dialog-scrollable modal-dialog-centered">
              <div class="modal-content">
                     <div class="modal-header">
                            <div class="modal-title">
                                   <h5>Cancelar cita</h5>
                            </div>
                            <button class="btn-close" data-bs-dismiss="modal" id="close"></button>
                     </div>
                     <div class="modal-body">

                            <div class="card-text">
                                   ¿Está seguro de que desea cancelar su cita?
                            </div>

                     </div>
                     <div class="card-footer">
                            <form id="form-cita" method="POST">
                                   <input type="hidden" name="cod_cita" value=<?php echo $fila["cod_cita"]?>>
                                   <button type="button" class="btn btn-danger" name="bCancelarCita" id="bCancelarCita">Eliminar</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                     </div>

              </div>
       </div>
</div>

<?php

}